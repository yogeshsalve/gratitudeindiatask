<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;

class ExamController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $exams = Exam::all();

      return view('exams', ['exams' => $exams]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $request->validate([
        'question'       => 'required|max:255',
        'option1' => 'required',
        'option2' => 'required',
        'option3' => 'required',
        'option4' => 'required',
        'category' => 'required',
      ]);

      $exam = Exam::updateOrCreate(['id' => $request->id], [
                'question' => $request->question,
                'option1' => $request->option1,
                'option2' => $request->option2,
                'option3' => $request->option3,
                'option4' => $request->option4,
                'category' => $request->category

              ]);

      return response()->json(['code'=>200, 'message'=>'Question Created successfully','data' => $exam], 200);

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      $exam = Exam::find($id);

      return response()->json($exam);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $exam = Exam::find($id)->delete();

    return response()->json(['success'=>'Question Deleted successfully']);
  }
}