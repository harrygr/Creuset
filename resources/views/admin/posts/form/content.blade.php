<div class="panel panel-default" id="postContent">
  <div class="panel-body">
    <cr-title-slugger value="{{ $post->title }}" slug="{{ $post->slug }}" name="title"></cr-title-slugger>

    <div class="form-group top-buffer" id="postContent">

      <cr-markarea value="{{ $post->content }}" name="content" title="Content"></cr-markarea>                

    </div>
  </div>
</div>