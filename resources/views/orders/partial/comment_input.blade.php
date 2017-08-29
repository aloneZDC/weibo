<div class="modal-content">
    <div class="modal-header">
        <button ng-click="$close(false)" type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <h6>{{ trans('store.create_comment_modal.create_comment') }}{{$order_id}}</h6>
    </div>

    <form action="{{ route('orders.store_comment') }}" method="POST" role="form" name="commentOrderForm">
        {{ csrf_field() }}
        <div class="modal-body">
            <div class="container-fluid">
                    {!! Form::hidden('order_id', $order_id, ['ng-model'=>'newComment.order_id']) !!}
                    <div class="row">
                        <div class="col-md-12">
                        {!! Form::label('comment_text',trans('store.create_comment_modal.text').':', ['class'=>'control-label']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::textarea('comment_text', null,
                                [
                                    'placeholder' => trans('store.create_comment_modal.create_comment_placeholder'),
                                    'class' => 'form-control form-group',
                                    'required' => 'required',
                                    'rows' => 3,
                                ]
                            ) !!}
                        </div>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary pull-left">{{ trans('store.create_comment_modal.save_new_comment') }}</button>
        </div>
    </form>

</div>
