<?php

namespace App\Controllers;

use App\Models\Encounter;
use App\Models\Token;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class EncountersController extends BaseController
{
    public function index(Request $request) : Response
    {
        return $this->html();
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
        $tokens = Token::getAll('enc_id = ?', [$encounter->getId()]);

        return $this->html(compact('encounter', 'tokens'));
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
    public function spectate(Request $request) : Response
    {
        // TODO: Join Encounter
        return $this->html();
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
