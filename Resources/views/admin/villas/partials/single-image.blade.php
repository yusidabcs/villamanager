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

            @if(@$villa)
             <a data href="{{ route('admin.villamanager.image.thumbnail', [$villa->id,$file->id]) }}" class="btn btn-default btn-flat btn-thumbnail data-toggle="tooltip" data-placement="top" title="Make as main thumbnail"><i class="fa fa-eye"></i></a>
             @endif
        </div>
    </td>
</tr>