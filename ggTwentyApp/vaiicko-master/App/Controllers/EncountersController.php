<?php

namespace App\Controllers;

use App\Models\Character;
use App\Models\Encounter;
use App\Models\Monster;
use App\Models\Token;
use App\Models\User;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class EncountersController extends BaseController
{
    public function authorize(Request $request, string $action): bool
    {
        return $this->app->getAuth()->isLogged();
    }
    public function index(Request $request) : Response
    {
        $characters = Character::getAll('user_id = ?', [$this->app->getAuth()->user->getId()]);

        return $this->html(compact('characters'));
    }
    public function encounter(Request $request) : Response
    {
        $encounters = Encounter::getAll('dm_id = ?', [$this->app->getAuth()->user->getId()]);
        if (empty($encounters))
        {
            $encounter = new Encounter();
            $encounter->setDmId($this->app->getAuth()->user->getId());
            $encounter->setCode($this->generateCode());
            $encounter->setCurrent(0);
            $encounter->save();
        }
        else
        {
            $encounter = $encounters[0];
        }
        $tokens = Token::getAll('enc_id = ?', [$encounter->getId()], 'initiative DESC');

        $dmchars = Character::getAll('user_id = ?', [$this->app->getAuth()->user->getId()]);
        $dmmonsters = Monster::getAll('user_id = ?', [$this->app->getAuth()->user->getId()]);

        return $this->html(compact('encounter', 'tokens', 'dmchars', 'dmmonsters'));
    }
    public function changeTokenPosition(Request $request) : Response
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['token_id'], $data['x'], $data['y'])) {
            return $this->json([
                'success' => false,
                'error' => 'Invalid data'
            ], 400);
        }

        $token = Token::getOne((int)$data['token_id']);
        if (is_null($token)) {
            return $this->json([
                'success' => false,
                'error' => 'Token not found'
            ], 404);
        }

        $token->setX((int)$data['x']);
        $token->setY((int)$data['y']);

        try {
            $token->save();
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }

        return $this->json(['success' => true]);
    }
    public function addMonster(Request $request) : Response
    {
        $monster = Monster::getOne($request->value('id'));
        if (!empty($monster) && $monster->getUserId() == $this->app->getAuth()->user->getId())
        {
            $token = new Token();
            $token->setEncId((int)$request->value('encounter_id'));
            $token->setName($monster->getName());
            $token->setImageUrl($monster->getImageUrl());
            $token->setX(0);
            $token->setY(0);
            $token->setInitiative((int)$request->value('initiative'));
            try
            {
                $token->save();
            } catch (\Exception $e)
            {
                throw new HttpException(500, 'DB Error: ' . $e->getMessage());
            }
        }

        return $this->redirect($this->url('encounter'));
    }
    public function addCharacter(Request $request) : Response
    {
        $character = Character::getOne($request->value('id'));
        if (!empty($character) && $character->getUserId() == $this->app->getAuth()->user->getId())
        {
            $token = new Token();
            $token->setEncId($request->value('encounter_id'));
            $token->setName($character->getName());
            $token->setImageUrl($character->getImageUrl());
            $token->setX(0);
            $token->setY(0);
            $token->setInitiative($request->value('initiative'));

            try
            {
                $token->save();
            } catch (\Exception $e){}
        }

        return $this->redirect($this->url('encounter'));
    }
    public function deleteEncounter(Request $request) : Response
    {
        $encounterId = (int)$request->value('id');
        // Delete Tokens
        $tokens = Token::getAll('enc_id = ?', [$encounterId]);
        try
        {
            foreach ($tokens as $token)
            {
                $token->delete();
            }
        } catch (\Exception $e)
        {
            throw new HttpException(500, 'DB Error: ' . $e->getMessage());
        }
        // Delete Encounter
        try {
            $encounter = Encounter::getOne($encounterId);
            if (is_null($encounter)) {
                throw new HttpException(404);
            }
            $encounter->delete();
        } catch (\Exception $e) {
            throw new HttpException(500, 'DB Error: ' . $e->getMessage());
        }

        return $this->redirect($this->url('index'));
    }
    public function deleteToken(Request $request) : Response
    {
        try {
            $id = (int)$request->value('id');
            $token = Token::getOne($id);

            if (is_null($token)) {
                throw new HttpException(404);
            }

            $token->delete();

        } catch (\Exception $e) {
            throw new HttpException(500, 'DB Error: ' . $e->getMessage());
        }

        return $this->redirect($this->url('encounter'));
    }
    public function endRound(Request $request) : Response
    {
        // Determine next
        $encounterId = (int)$request->value('id');
        $tokes = Token::getAll('enc_id = ?', [$encounterId]);
        if (count($tokes) == 0)
            return $this->redirect($this->url('encounter'));

        $encounter = Encounter::getOne($encounterId);
        $nextCurrent = ($encounter->getCurrent() + 1) % count($tokes);
        // Save as current
        try
        {
            $encounter->setCurrent($nextCurrent);
            $encounter->save();
        } catch (\Exception $e)
        {
            throw new HttpException(500, 'DB Error: ' . $e->getMessage());
        }

        return $this->redirect($this->url('encounter'));
    }
    public function spectate(Request $request) : Response
    {
        $encounters = Encounter::getAll('code = ?', [$request->value('code')]);
        if (!$encounters)
            return $this->redirect($this->url('index'));

        $tokens = Token::getAll('enc_id = ?', [$encounters[0]->getId()], 'initiative DESC');
        $dmName = User::getOne($encounters[0]->getDmId())->getUsername();

        return $this->html([
            'encounter' => $encounters[0],
            'tokens' => $tokens,
            'dmName' => $dmName
        ]);
    }
    public function spectateData(Request $request): Response
    {
        $encounterId = (int)$request->value('enc_id');
        $encounter = Encounter::getOne($encounterId);

        if (!$encounter) {
            return $this->json(['error' => 'Encounter not found'], 404);
        }

        $tokens = Token::getAll(
            'enc_id = ?',
            [$encounter->getId()],
            'initiative DESC'
        );

        return $this->json([
            'current' => $encounter->getCurrent(),
            'tokens' => array_map(fn($t) => [
                'id' => $t->getId(),
                'name' => $t->getName(),
                'img' => $t->getImageUrl(),
                'x' => $t->getX(),
                'y' => $t->getY()
            ], $tokens)
        ]);
    }
    private function generateCode() : string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        do
        {
            $code = '';
            for ($i = 0; $i < 5; $i++)
            {
                $code .= $characters[rand(0, strlen($characters) - 1)];
            }
        } while (!empty(Encounter::getAll('code = ?', [$code])));

        return $code;
    }
}
