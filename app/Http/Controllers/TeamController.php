<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;

class TeamController extends Controller
{
    public function registForm() {
        return view('iheart.admin.team.regist');
    }
    // 팀 등록
    public function regist(Request $request) {
        // form validation
        $errMessages = [
            'name.required'    => '팀 이름은 필수 입력 항목입니다.', 
            'name.unique'      => '이미 사용중인 이름입니다.', 
            'name.max'         => '이름은 255글자를 넘을 수 없습니다.',
        ];
        $this->validate($request, [
            'name' => 'required|unique:teams|max:255'
        ], $errMessages);

        $team = new Team;
        $team->name = $request->name;
        if($request->has('location')) {
            $team->location = $request->location;
        }
        $team->sortKey = Team::max('sortKey') + 1;

        $team->save();

        return redirect()->route('iheart.admin.teams.show');
    }

    // 팀 전체조회
    public function show() {
        $teams = Team::orderBy('sortKey', 'asc')->get();
        return view('iheart.admin.team.list')->with('teams', $teams);
    }

    // 팀 상세조회
    public function detail(Request $request) {
        $id = $request->team_id;
        $team = Team::where('id', $id);
        return view('iheart.admin.team.detail')->with('team', $team);
    }

    // 팀 정보 수정
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

    // 팀 정렬 수정 Ajax
    public function updateSort(Request $request) {
        $resJson = array();
        $resJson["CODE"] = 200;
        $resJson["DATA"] = "UPDATE SUCCESS";
        $teamsJsonArr = json_decode($request->getContent());
        
        try {
            foreach($teamsJsonArr as $teamJson) {
                $team = Team::where('id', $teamJson->teamId)->first();
                $team->sortKey = $teamJson->sortKey;
                $team->save();
            }
        } catch(\Exception $e) {
            // DB 오류
            $resJson["CODE"] = 400;
            $resJson["ERROR"] = $e->getMessage();
        }
        

        return json_encode($resJson);

    }
}
