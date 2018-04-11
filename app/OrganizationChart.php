<?php

namespace App;

use App\User;
use App\Team;
use Debugbar;

class OrganizationChart 
{
    public function makeOrganizationsJsonData() {
        $teams = Team::orderBy('sortKey', 'asc')->get();
        // bootstrap-treeview 의 형태에 맞게 만들어준다.
        $rsltArray = array();
        foreach($teams as $team) {
            $teamArray = array();
            $teamArray["text"] = $team->name;
            $teamArray["team_id"] = $team->id;
            $teamArray["nodes"] = array();
            $users = $team->users;

            foreach($users as $user) {
                $userArr = array();
                $userArr["text"] = $user->name;
                $userArr["user_id"] = $user->id;

                array_push($teamArray["nodes"], $userArr);
            }
            array_push($rsltArray, $teamArray);
        }
        Debugbar::info($rsltArray);
        return json_encode($rsltArray);
    }
   
}
