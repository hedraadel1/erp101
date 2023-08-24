<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-lg">


        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                {{ $video->name }}
            </h4>


        </div>

        <div class="modal-body">
            @if ($video->video)
                <video width="100%" height="350PX" class="demo cursor" style="border: 1px solid #fafafa;" controls>
                    <source src="{{ asset($video->video) }}" type="video/mp4">
                </video>
            @else
                <iframe width="100%" height="350PX" src="//www.youtube.com/embed/{{ $video->video_id }}"
                    frameborder="0" allowfullscreen></iframe>
                {{-- <iframe src="{{ $item->video_url }}" frameborder="0"></iframe> --}}
            @endif
            {{-- <video width="100%" height="350px" class="demo cursor" style="border: 1px solid #fafafa;" controls>
                <source src="{{ asset($video->video) }}" type="video/mp4">
            </video> --}}
            <div class="desc" style="padding:15px">
                <p class="h4 text-{{ isRtl() ? 'right' : 'left' }}">الوصف</p>
                <p class="description" style="color:gray; ">
                    {{ $video->description }}
                </p>
            </div>

        </div>


        </form>


    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
