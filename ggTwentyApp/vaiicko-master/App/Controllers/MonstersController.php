<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\Monster;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use HttpException;

class MonstersController extends BaseController
{
    public function authorize(Request $request, string $action): bool
    {
        return $this->app->getAuth()->isLogged();
    }
    public function index(Request $request) : Response
    {
        $monsters = Monster::getAll('user_id = ?', [$this->app->getAuth()->user->getId()]);

        return $this->html(compact('monsters'));
    }
    public function add(Request $request) : Response
    {
        if (!$request->hasValue('submit'))
            return $this->html();

        $name = trim($request->value('monster-name'));
        if ($name === '')
        {
            $message = 'Monster name is required!';
            return $this->html(compact('message'));
        }
        if (mb_strlen($name) > 20)
        {
            $message = 'Monster name is too long! (Max 20 characters)';
            return $this->html(compact('message'));
        }
        $hp = (int)$request->value('monster-hp');
        $currentHp = $hp;
        $userId = (int)$this->app->getAuth()->user->getId();

        $imgFile = $request->file('monster-img');
        $targetPath = Configuration::UPLOAD_DIR . '_default_monst.png';
        if ($imgFile)
        {
            $uniqueName = time() . '-' . $imgFile->getName();
            $targetPath = Configuration::UPLOAD_DIR . $uniqueName;
            if (!$imgFile->store($targetPath))
                $targetPath = Configuration::UPLOAD_DIR . '_default_monst.png';
        }

        $monster = new Monster();
        $monster->setName($name);
        $monster->setHp($hp);
        $monster->setCurrentHp($currentHp);
        $monster->setUserId($userId);
        $monster->setImageUrl($targetPath);

        try
        {
            $monster->save();
            return $this->redirect($this->url('monsters.index'));
        } catch (\Exception $e) {
            return $this->html();
        }
    }
    public function delete(Request $request): Response
    {
        try
        {
            $id = (int)$request->value('id');
            $monster = Monster::getOne($id);

            // User's monster check
            $currentUserId = $this->app->getAuth()->user->getId();
            if ($monster->getUserId() !== $currentUserId)
                throw new HttpException(403, 'Unauthorized access to monster!');
            if (is_null($monster))
                throw new HttpException(404);

            if ($monster->getImageUrl() !== Configuration::UPLOAD_DIR . '_default_monst.png')
                @unlink($monster->getImageUrl());

            $monster->delete();
        } catch (\Exception $e)
        {
            throw new HttpException(500, 'DB Error: ' . $e->getMessage());
        }

        return $this->redirect($this->url('monsters.index'));
    }
}
