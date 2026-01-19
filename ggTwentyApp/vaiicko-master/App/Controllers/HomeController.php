<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\Character;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use HttpException;

class HomeController extends BaseController
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
    public function add(Request $request) : Response
    {
        if (!$request->hasValue('submit'))
        {
            return $this->html();
        }

        $name = trim($request->value('character-name'));
        if ($name === '')
        {
            $message = 'Character name is required!';
            return $this->html(compact('message'));
        }
        if (mb_strlen($name) > 29)
        {
            $message = 'Character name is too long! (Max 29 characters)';
            return $this->html(compact('message'));
        }
        $hp = (int)$request->value('character-hp');
        $currentHp = $hp;
        $ac = (int)$request->value('character-ac');
        $userId = (int)$this->app->getAuth()->user->getId();

        $imgFile = $request->file('character-img');
        $targetPath = Configuration::UPLOAD_DIR . '_default_char.png';
        if ($imgFile)
        {
            $uniqueName = time() . '-' . $imgFile->getName();
            $targetPath = Configuration::UPLOAD_DIR . $uniqueName;
            if (!$imgFile->store($targetPath))
                $targetPath = Configuration::UPLOAD_DIR . '_default_char.png';
        }

        $character = new Character();
        $character->setName($name);
        $character->setHp($hp);
        $character->setCurrentHp($currentHp);
        $character->setAc($ac);
        $character->setUserId($userId);
        $character->setImageUrl($targetPath);

        try {
            $character->save();
            return $this->redirect($this->url('home.index'));
        } catch (\Exception $e) {
            $message = 'Error saving character: ' . $e->getMessage();
            return $this->html(compact('message'));
        }
    }
    public function edit(Request $request): Response
    {
        $id = (int)$request->value('character-id');
        $char = Character::getOne($id);

        // Kontrola, či postava patrí prihlásenému userovi
        $currentUserId = $this->app->getAuth()->user->getId();
        if ($char->getUserId() !== $currentUserId) {
            return $this->json([
                'status' => 'error',
                'message' => 'Unauthorized access to character.'
            ]);
        }

        $char->setName($request->value('character-name'));
        $char->setHp((int)$request->value('character-hp'));
        $char->setCurrentHp((int)$request->value('character-cur-hp'));
        $char->setAc((int)$request->value('character-ac'));

        $imgFile = $request->file('character-img');
        if ($imgFile && $imgFile->isOk())
        {
            $oldFileUrl = $char->getImageUrl();
            if ($oldFileUrl !== Configuration::UPLOAD_DIR . '_default_char.png')
            {
                if (file_exists($oldFileUrl) && is_file($oldFileUrl))
                    @unlink($oldFileUrl);
            }
            $newFileName = time() . '-' . $imgFile->getName();
            $targetPath = Configuration::UPLOAD_DIR . $newFileName;
            if ($imgFile->store($targetPath))
                $char->setImageUrl($targetPath);

        }

        try {
            $char->save();

            return $this->json([
                'status' => 'success',
                'message' => 'Character updated successfully.',
                'new_image_url' => $char->getImageUrl()
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => 'Error saving character.',
                'detail' => $e->getMessage()
            ]);
        }
    }
    public function delete(Request $request): Response
    {
        try {
            $id = (int)$request->value('id');
            $char = Character::getOne($id);

            // Kontrola, či postava patrí prihlásenému userovi
            $currentUserId = $this->app->getAuth()->user->getId();
            if ($char->getUserId() !== $currentUserId) {
                throw new HttpException(403, 'Unauthorized access to character.');
            }

            if (is_null($char)) {
                throw new HttpException(404);
            }
            if ($char->getImageUrl() !== Configuration::UPLOAD_DIR . '_default_char.png')
                @unlink($char->getImageUrl());

            $char->delete();

        } catch (\Exception $e) {
            throw new HttpException(500, 'DB Error: ' . $e->getMessage());
        }

        return $this->redirect($this->url('home.index'));
    }
    public function character(Request $request): Response
    {
        $id = (int)$request->value('id');
        $char = Character::getOne($id);

        return $this->html(compact('char'));
    }
    public function logout(Request $request): Response
    {
        $this->app->getAuth()->logout();
        return $this->redirect(Configuration::LOGIN_URL);
    }

}