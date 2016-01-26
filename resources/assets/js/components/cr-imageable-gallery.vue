<template>
	<!-- Post images -->  
	<div class="box box-primary" id="post-images">
		<div class="box-header">
			Attached Images
		</div>

		<div class="box-header" v-if="selectedImage > -1">

			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" @click="selectedImage = -1">&times;</span></button>

			<div class="row">
				<div class="col-md-4">
					<img class="img-thumbnail img-responsive" v-bind:src="images[selectedImage].thumbnail_url" alt=""> 
				</div>
				<div  class="col-md-8">
					<div class="form-group">
						<label>URL: </label>
						<input type="text" class="form-control input-sm" readonly value="{{ images[selectedImage].url }}">
					</div>    

					<div class="form-group">
						<label>Thumbnail: </label>
						<input type="text" class="form-control input-sm" readonly value="{{ images[selectedImage].thumbnail_url }}">
					</div>

					<div class="form-group">
						<label>Image Title</label>
						<input type="text" v-model="customProperties.title" class="form-control" @keyup.enter="updateImage">
					</div>

					<div class="form-group">
						<label>Caption</label>
						<textarea v-model="customProperties.caption" class="form-control"></textarea>
					</div>
					
					<button type="button" @click="updateImage" class="btn btn-primary">Update Image</button>
					<button type="button" @click="deleteImage" class="btn btn-danger">Delete Image</button>
					<button type="button" @click="selectedImage = -1" class="btn btn-link">Cancel</button>

					<p class="form-group top-buffer">
					<span v-if="imageUpdating"><i class="fa fa-circle-o-notch fa-spin"></i> Working...</span>
					<span class="text-success" v-if="imageUpdatedMessage"> <i class="fa fa-check"></i> {{ imageUpdatedMessage }}</span>
					</p>
				</div>
			</div>
		</div>

		<div class="box-body">

			<span v-if="imagesLoading"><i class="fa fa-circle-o-notch fa-spin"></i> Loading images...</span>

			<div class="row" v-if="hasImages">
			    <div class="col-md-2 col-sm-3 col-xs-6 top-buffer" v-for="image in images">
					<img v-bind:src="image.thumbnail_url" alt="" class="img-responsive img-thumbnail selectable" v-bind:class="{'selected': isSelected(image.id)}" @click="selectImage($index)">
				</div>
			</div>

			<span v-if="!hasImages">No Images yet</span>

		</div>
	</div>
</template>

<script>
	module.exports = {
		props: ['imageableUrl'],

		data: function () {
			return {
				images: [],
				selectedImage: -1,
				imagesLoading: false,
				imageUpdating: false,
				imageUpdatedMessage: false,
                customProperties: {
                    title: '',
                    caption: ''
                }
			}
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

				this.$http.get(this.imageableUrl).success(function(response)
				{
					this.images = response;
					this.imagesLoading = false;

				});

			},

			updateImage: function(e)
			{
                var selectedImage = this.selectedImage;

				this.imageUpdating = true;
                this.images[selectedImage].custom_properties = this.customProperties;
				this.$http.patch('/api/media/' + this.images[selectedImage].id, this.images[selectedImage]).success(function(response) {
                    this.images[selectedImage] = response;
					this.imageUpdating = false;
					this.showMessage('Done');
				});
			},

			deleteImage: function(e)
			{
				if (confirm("Are you sure?")) {
                    var selectedImage = this.selectedImage;

					this.$http.delete('/api/media/' + this.images[selectedImage].id).success(function(response) {
						this.showMessage(response);
						this.fetchImages();
						this.selectedImage = -1;
					}.bind(this));
				}
			},

			showMessage: function(message) {
				this.imageUpdatedMessage = message;
				setTimeout(function(){ this.imageUpdatedMessage = false}.bind(this), 5000);
			},

			selectImage(index)
			{
				this.selectedImage = index;
                console.log(index);
                this.customProperties.title = this.images[index].custom_properties.title || '';
                this.customProperties.caption = this.images[index].custom_properties.caption || '';
			},

			isSelected: function(id)
			{
				return this.selectedImage > -1 && this.images[this.selectedImage].id == id;
			},

			url: function(image, thumbnail)
			{
				thumbnail = thumbnail || false;

				var url = '/images/' + image.id;
				if (thumbnail) {
					url += '?thumbnail=1';
				}
				return url;
			}
		}
	};
</script>