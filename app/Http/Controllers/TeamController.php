<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function registForm() {
        return view('iheart.admin.team.regist');
    }
    // 팀 등록
    public function regist(Request $request) {
        $team = new Team;
        if($request->has('name')) { 
            $team->name = $request->name;
        } else {
            abort(400); // bad request
        }

        if($request->has('location')) {
            $team->location = $request->location;
        }

        $team->save();

        return redirect()->route('iheart.admin.teams.show');
    }

    // 팀 전체조회
    public function show() {
        $teams = Team::paginate(10);
        return view('iheart.admin.team.list')->with('teams', $teams);
    }

    // 팀 상세조회
    public function detail(Request $request) {
        $id = $request->team_id;
        $team = Team::where('id', $id);
        return view('iheart.admin.team.detail')->with('team', $team);
    }


    public function update(Request $request) {
        $id = $request->team_id;
        $team = Team::where('id', $id);

        if($request->has('name')) { 
            $team->name = $request->name;
        }
        
        if($request->has('location')) { 
            $team->location = $request->location;
        }
        $team->save();

        return redirect()->route('iheart.admin.teams.show');

    }

    public function delete(Request $request) {

    }
}
