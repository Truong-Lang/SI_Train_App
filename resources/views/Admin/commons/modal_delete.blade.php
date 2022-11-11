<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="post">
            @csrf
            <input type="hidden" name="id" class="input-id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('Are you sure you want to delete ?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-sm mr-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js')
    <script>
        $('.delete').on('click', function(){
            $('.input-id').val($(this).data('id'))
        });
    </script>
@endpush