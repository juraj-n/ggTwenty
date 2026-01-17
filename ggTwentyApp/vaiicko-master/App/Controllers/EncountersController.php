<?php

namespace App\Controllers;

use App\Models\Encounter;
use App\Models\Token;
use Framework\Core\BaseController;
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
