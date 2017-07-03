<li class="dd-item" data-id="1" id="{{ $file->id }}">
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

                    @if(@$villa)
                        <a data href="{{ route('admin.villamanager.image.thumbnail', [$villa->id,$file->id]) }}" class="btn btn-default btn-flat btn-thumbnail data-toggle="tooltip" data-placement="top" title="Make as main thumbnail"><i class="fa fa-eye"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</li>