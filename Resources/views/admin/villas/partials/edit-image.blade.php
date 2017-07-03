<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div method="POST" class="dropzone">
                {!! Form::token() !!}
            </div>
            <div class="row text-right">
                <div class="col-md-12">
                    <button type="button" class="btn btn-danger" id="delete_all" value="Delete All" data-action-target="{{ route('admin.villamanager.image.delete-all') }}"><i class="fa fa-trash"></i></button>
                </div>
            </div>
            <div class="row text-info">
                <div class="col-md-1">
                    <label>
                        <input type="checkbox" id="delete_checkbox" value="1">
                    </label>
                </div>
                <div class="col-md-2">
                    {{ trans('core::core.table.thumbnail') }}
                    </div>
                <div class="col-md-4">
                    {{ trans('media::media.table.filename') }}
                    </div>
                <div class="col-md-3">
                    {{ trans('core::core.table.created at') }}
                    </div>
                <div class="col-md-2">
                    {{ trans('core::core.table.actions') }}
                    </div>
            </div>

            <div class="dd">
                <ol class="dd-list">
                    <?php if ($villa->images): ?>
                        <?php foreach ($villa->images as $file): ?>
                        <li class="dd-item" data-id="{{ $file->id }}" id="{{ $file->id }}">
                            <div class="dd-handle">
                                <div class="row btn-thumbnail-tr">
                                    <div class="col-md-1 dd-nodrag">
                                        <input type="checkbox" class="delete_checkbox dd-nodrag" value="{{ $file->id }}">
                                    </div>
                                    <div class="col-md-2">
                                        <?php if ($file->isImage()): ?>
                                        <img src="{{ Imagy::getThumbnail($file->path, 'smallThumb') }}" class="img img-responsive" alt=""/>
                                        <?php else: ?>
                                        <i class="fa fa-file" style="font-size: 20px;"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4">
                                        {{ $file->filename }}
                                    </div>
                                    <div class="col-md-3">
                                        {{ $file->created_at }}
                                    </div>
                                    <div class="col-md-2 dd-nodrag">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.media.media.edit', [$file->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>

                                            <button type="button" class="btn btn-danger btn-flat btn-delete-file {{ 'file-'.$file->id }}" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.villamanager.image.destroy', [$file->id]) }}"><i class="fa fa-trash"></i></button>

                                            <a data href="{{ route('admin.villamanager.image.thumbnail', [$villa->id,$file->id]) }}" class="btn btn-default btn-flat {{  $file->pivot->thumbnail == 1 ? '':'btn-thumbnail'  }}" data-toggle="tooltip" data-placement="top" title="Make as main thumbnail"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ol>
            </div>
        </div>
    </div>
</div>