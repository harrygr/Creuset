<div class="panel panel-default" id="postContent">
  <div class="panel-body">

    <div class="form-group">
      <label for="title" class="sr-only">Title</label>
      {!! Form::text('title', null, [
        'class' => 'post-title-input', 
        'placeholder' => "Title", 
        'v-model' => 'title',
        'v-on' => 'blur: setNewSlug'
        ]) !!}                    
      </div>

      <label for="slug" class="sr-only">Slug</label>
      <div class="input-group">
        {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => "Slug" , 'v-model' => 'slug']) !!}   

        <span class="input-group-btn refresh-slug">
          <button class="btn btn-default" type="button" v-on="click: sluggifyTitle"><i class="fa fa-fw fa-refresh"></i></button>
        </span>
      </div>

      <div class="form-group top-buffer row" id="postContent">
        <div class="col-md-6">
        <label for="content" class="sr-only">Content</label>
        
        {!! Form::textarea('content', null, [
          'class' => 'form-control', 
          "id" => "post-content-input", 
          'placeholder' => 'Content (Markdown/HTML)', 
          'v-model' => 'content'
          ]) !!}
        </div>

      <div class="col-md-6">                    
        <div class="" v-html="content | marked"></div>
      </div>                   

    </div>
  </div>
</div>