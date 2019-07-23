<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Comments;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    protected $types = [ 'approved', 'pending', 'spam' ];
    protected $options = [
        'with'       => 'post',
        'withSelect' => [ 'post_id', 'title', 'url' ]
    ];

    public function get_comments(Request $request)
    {

        $type = $request->get('status');
        if ($request->has('search')) {
            $comments = Comments::search($request);
            $records = $comments->paginate(20);
        } else if ($request->has('comment')) {
            $records = \App\Models\Comments::where('comment_id', $request->get('comment'))->paginate(20);
        } else if ($request->has('post')) {
            $records = \App\Models\Comments::with(['post' => function($query){
                return $query->select($this->options['withSelect']);
            }])->where('post_id',$request->get('post'))->orderByDesc('created_at')->paginate(20);
        } else {
            $records = Comments::paginate(array_merge(Helper::findStatusOnParam($type, $this->types), $this->options), 20, $request->get('status'), $request->get('page'));
        }
        return view('rix.comments')->with([
            'comments' => $records,
            'typeData' => Comments::getTypeData([ 'type' => $type ])
        ]);
    }

    public function action_comments(Request $request)
    {
        if ($request->ajax())
            return Comments::doCommentAction($request->input('data'), $request->input('action'));
    }
}
