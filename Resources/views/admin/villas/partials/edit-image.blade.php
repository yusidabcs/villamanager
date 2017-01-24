<div class="box-header">
    <h4 class="box-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#images">
        Images
        </a>
    </h4>
</div>
<div style="height: 0px;" id="images" class="panel-collapse collapse">
    <div class="box-body">
         <div class="row">
        <div class="col-md-12">
            <div method="POST" class="dropzone">
                {!! Form::token() !!}
            </div>
            <table class="data-table table table-bordered table-hover jsFileList">
                    <thead>
                        <tr>
                            <th>{{ trans('core::core.table.thumbnail') }}</th>
                            <th>{{ trans('media::media.table.filename') }}</th>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($villa->images): ?>
                            <?php foreach ($villa->images as $file): ?>
                                <tr class="btn-thumbnail-tr">
                                    <td>
                                        <?php if ($file->isImage()): ?>
                                            <img src="{{ Imagy::getThumbnail($file->path, 'smallThumb') }}" alt=""/>
                                        <?php else: ?>
                                            <i class="fa fa-file" style="font-size: 20px;"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.media.media.edit', [$file->id]) }}">
                                            {{ $file->filename }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.media.media.edit', [$file->id]) }}">
                                            {{ $file->created_at }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.media.media.edit', [$file->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>

                                            <button type="button" class="btn btn-danger btn-flat btn-delete-file {{ 'file-'.$file->id }}" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.villamanager.image.destroy', [$file->id]) }}"><i class="fa fa-trash"></i></button>

                                            <a data href="{{ route('admin.villamanager.image.thumbnail', [$villa->id,$file->id]) }}" class="btn btn-default btn-flat {{  $file->pivot->thumbnail == 1 ? '':'btn-thumbnail'  }}" data-toggle="tooltip" data-placement="top" title="Make as main thumbnail"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ trans('core::core.table.thumbnail') }}</th>
                            <th>{{ trans('media::media.table.filename') }}</th>
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                    </tfoot>
                </table>
        </div>
    </div>       
    </div>
</div>