<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Course $course)
    {
        //
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|array',
            'answer.*' => 'required|string',
            'correct_answer' => 'required|integer',
          ]);
   
          DB::beginTransaction();
   
          try {

              $question = $course->question()->create([
                'question' => $request->question

              ]);
               
               $validated['slug'] = Str::slug($request->name);
               $newCourse = Course::create($validated);
   
               DB::commit();
   
               return redirect()->route('dashboard.courses.index');
          }
   
          catch(\Exception $e){
               DB::rollBack();
               $error = ValidationException::withMessages([
                   'system_error' => ['system error!' . $e->getMessage()],
               ]);
   
               throw $error;
          }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        //
        $students = $course->students()->orderBy('id', 'DESC')->get();
        return view('admin.questions.create', [
            'course' => $course,
            'students' => $students
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseQuestion $courseQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseQuestion $courseQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseQuestion $courseQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseQuestion $courseQuestion)
    {
        //
    }
}
