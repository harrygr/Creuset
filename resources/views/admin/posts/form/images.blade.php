<!-- Post images -->  
<div class="panel panel-default" id="post-images">
  <div class="panel-heading">
    Attached Images
  </div>

  <div class="panel-heading" v-if="selectedImage.id">

    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" v-on="click: selectedImage = {}">&times;</span></button>

    <div class="row">
      <div class="col-md-4">
        <img class="media-object img-thumbnail img-responsive" v-attr="src: selectedImage.thumbnail_url" alt=""> 
      </div>
      <div  class="col-md-8">
        <div class="form-group">
          <label>URL: </label>
          <input type="text" class="form-control input-sm" readonly value="@{{ selectedImage.url }}">
        </div>    

        <div class="form-group">
          <label>Thumbnail: </label>
          <input type="text" class="form-control input-sm" readonly value="@{{ selectedImage.thumbnail_url }}">
        </div>

        <div class="form-group">
            <label>Image Title</label>
            <input type="text" v-model="selectedImage.title" class="form-control">
        </div>

        <div class="form-group">
            <label>Caption</label>
            <textarea v-model="selectedImage.caption" class="form-control"></textarea>
        </div>

        <button v-on="click: updateImage" class="btn btn-primary" v-attr="disabled: imageUpdating">Update Image</button>
        <span v-if="imageUpdating"><i class="fa fa-circle-o-notch fa-spin"></i> Saving...</span>
        <span class="text-success" v-if="imageUpdatedMessage"> <i class="fa fa-check"></i> @{{ imageUpdatedMessage }}</span>
      </div>
    </div>
  </div>

  <div class="panel-body">
    @if ($post->id)
    <span v-if="imagesLoading"><i class="fa fa-circle-o-notch fa-spin"></i> Loading images...</span>

    <div class="row" v-if="hasImages">
      <div class="col-md-2 col-sm-3 col-xs-6 top-buffer" v-repeat="image: images">
        <img v-attr="src: image.thumbnail_url" alt="" class="img-responsive img-thumbnail selectable" v-class="selected: isSelected(image.id)" v-on="click: selectedImage = image">
      </div>
    </div>

    <span v-if="!hasImages">No Images yet</span>

    @else
    Save the {{ $post->type }} to attach images
    @endif
  </div>
</div>


@section('admin.scripts')
@parent

@if ($post->id)
<script>
  postImageVm = new Vue({
    el: "#post-images",

    data: {
      images: [],
      selectedImage: {},
      imagesLoading: false,
      imageUpdating: false,
      imageUpdatedMessage: false
    },

    computed: {
      hasImages: function()
      {
        return this.images.length > 0;
      }
    },

    ready: function()
    {
      this.fetchImages();
    },

    methods: {
      fetchImages: function()
      {
        this.imagesLoading = true;

        this.$http.get('{{ route('api.posts.images', $post->id) }}').success(function(response)
        {
          this.images = response;
          this.imagesLoading = false;

        });

      },

      updateImage: function(e)
      {
        e.preventDefault();
        this.imageUpdating = true;
        this.$http.patch('/api/images/' + this.selectedImage.id, this.selectedImage).success(function(response)
        {
          this.imageUpdating = false;
          this.imageUpdatedMessage = 'Done';
          setTimeout(function(){ this.imageUpdatedMessage = false}.bind(this), 5000);
        });
      },

      isSelected: function(id)
      {
        return this.selectedImage.id == id;
      },

      url: function(image, thumbnail)
      {
        thumbnail = thumbnail || false;

        var url = '{{ url('/images') }}' + '/' + image.id;
        if (thumbnail) {
          url += '?thumbnail=1';
        }
        return url;
      }
    }
  });
</script>
@endif
@stop