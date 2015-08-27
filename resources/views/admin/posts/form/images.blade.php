<!-- Post images -->  
<div class="panel panel-default" id="post-images">
  <div class="panel-heading">
    Attached Images
  </div>

  <div class="panel-heading" v-if="selectedImage.id">

    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" v-on="click: selectedImage = {}">&times;</span></button>

    <div class="row">
      <div class="col-md-4">
        <img class="media-object img-thumbnail" src="/@{{ selectedImage.thumbnail_path}}" alt=""> 
      </div>
      <div  class="col-md-8">
        <p>
          <strong>URL: </strong>
          <input type="text" class="form-control input-sm" readonly value="{{ url() }}/@{{ selectedImage.path }}">
        </p>    

        <p>
          <strong>Thumbnail: </strong>
          <input type="text" class="form-control input-sm" readonly value="{{ url() }}/@{{ selectedImage.thumbnail_path }}">
        </p>
      </div>
    </div>
  </div>

  <div class="panel-body">
    @if ($post->id)
    <span v-if="imagesLoading"><i class="fa fa-circle-o-notch fa-spin"></i> Loading images...</span>

    <div class="row" v-if="hasImages">
      <div class="col-md-2 col-sm-3 col-xs-6 top-buffer" v-repeat="image: images">
        <img src="@{{ '/' + image.thumbnail_path }}" alt="" class="img-responsive img-thumbnail selectable" v-class="selected: isSelected(image.id)" v-on="click: selectedImage = image">
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
      imagesLoading: false
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
      isSelected: function(id)
      {
        return this.selectedImage.id == id;
      }
    }
  });
</script>
@endif
@stop