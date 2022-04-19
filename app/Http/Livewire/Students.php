<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class Students extends Component
{
    public $student_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;

    public function resetInputFields(){
        $this->first_name='';
        $this->last_name='';
        $this->email='';
        $this->phone='';
    }

    public function  store()
    {
        $validateData=$this->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'phone'=>'required',
        ]);
        Student::query()->create($validateData);
        session()->flash('message','Student Created Successfully');
        $this->resetInputFields();
        $this->emit('studentAdded');
    }

    public function edit($id){
        $student=Student::query()->find($id);
        $this->student_id=$student->id;
        $this->first_name=$student->first_name;
        $this->last_name=$student->last_name;
        $this->email=$student->email;
        $this->phone=$student->phone;
    }

    public function update(){
        $this->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'phone'=>'required',
        ]);
        if ($this->student_id){
            $student=Student::query()->find($this->student_id);
            $student->update([
                'first_name'=>$this->first_name,
                'last_name'=>$this->last_name,
                'email'=>$this->email,
                'phone'=>$this->phone,
            ]);
            session()->flash('message','Student Updated Successfully');
            $this->resetInputFields();
            $this->emit('studentUpdated');
        }
    }

    public function delete($id)
    {
        if ($id){
            Student::query()->find($id)->delete();
            session()->flash('message','Student Delete Successfully');

        }
    }

    public function render()
    {
        $students=Student::query()->orderBy('id','DESC')->get();
        return view('livewire.students',compact('students'));
    }
}
