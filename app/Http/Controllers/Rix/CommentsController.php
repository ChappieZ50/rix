<?php

namespace App\Http\Controllers\Rix;

use App\Classes\Comments;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    protected $types = [ 'approved', 'pending', 'spam' ];

    public function get_comments(Request $request)
    {
        $type = $request->get('status');
        $typeData = [ 'type' => $type ];
        $paramType = Helper::findStatusOnParam($type, $this->types);
        if ($request->get('post'))
            $typeData = array_merge([ 'post_id' => $request->get('post') ], $typeData);
        $options = [
            'with'       => 'post',
            'withSelect' => [ 'post_id', 'title', 'url' ]
        ];
        $data = Comments::getCommentsWithCount(array_merge($paramType, $options), $typeData);
        if ($request->get('search')) {
            $value = $request->get('search');
            $data['comments']->where(function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%')
                    ->orWhere('email', 'like', '%' . $value . '%')
                    ->orWhere('comment', 'like', '%' . $value . '%');
            });
        }
        if ($request->get('comment'))
            $data['comments']->where('comment_id', $request->get('comment'));
        return view('rix.comments')->with([
            'comments' => $data['comments']->paginate(20),
            'typeData' => $data['count']
        ]);
    }

    public function action_comments(Request $request)
    {
        if ($request->ajax())
            return Comments::doCommentAction($request->input('data'), $request->input('action'));
    }
}
