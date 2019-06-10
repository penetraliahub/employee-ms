<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Skill;
use App\Employee;
use App\Http\Controllers\Controller;
use Session; 
use Illuminate\Validation\Rule;

class SkillController extends Controller
{
    public function index()
     {
  $employees = Employee::all();
     return view('pages.admin.skills.find',  compact("employees"));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('pages.admin.skills.create', compact("employees"));
    }

    public function store(Request $request)
    {
    $rules = [
            'skill_title' => 'required|unique:skills,skill_title'

        ];



        $customMessages = [
            'skill_title.required' => 'Please provide the skill title.',
            'skill_title.unique' => 'skills already exist.',
        ];

        $this->validate($request, $rules, $customMessages); 

        Skill::create($request->all());

        notify()->success("Successfully created!","","bottomRight");
        return redirect()->route('skills.show', ['id' => $request->employee_id]);
    }

    public function show($id)
    {
        $skills = Skill::where('employee_id', $id)->get();
        return view('pages.admin.skills.list', compact('skills'));
       
    }

    public function update(Request $request,Skill $skill)
    {
        $rules = [
            'skill_title' => [
                'required',
                Rule::unique('skills')->ignore($skill->id)
            ],
        ];

          $customMessages = [
            'skill_title.required' => 'Please provide the skill title.',
            'skill_title.unique' => 'skills already exist.',
        ];
     $this->validate($request, $rules, $customMessages);

        $skill->update($request->all());

        notify()->success("Successfully Updated!","","bottomRight");
        return redirect()->route('skills.show', ['id' => $skill->employee_id]);
    }

      public function edit(Skill $skill)
    {
        $employees = Employee::all();
        return view('pages.admin.skills.edit', compact('skill','employees'));
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
            notify()->success("Successfully Deleted!","","bottomRight");
            return redirect()->route('skills.show', ['id' => $skill->employee_id]);
    }
}
