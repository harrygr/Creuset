<template>
	<div class="panel panel-default" id="featuredImageChooser">
		<div class="panel-heading">
			Featured Image
		</div>
		<div class="panel-body">
			<p v-if="!chosenImage" class="text-center">None Chosen</p>

			<img 
				v-if="chosenImage" 
				v-bind:src="chosenImage.thumbnail_url" 
				alt="chosenImage.description" 
				class="img-responsive thumbnail"
				style="width:100%;"
			>

			<!-- Button trigger modal -->
			<button 
				type="button" 
				class="btn btn-default" 
				data-toggle="modal" 
				data-target="#imagesModal" 
				@click="fetchImages()"
			>Choose</button>

			<button 
				type="button" 
				class="btn btn-link text-danger" 
				v-if="chosenImage"
				@click="chosenImage = {}"
			>Remove Image</button>

			<input 
				type="hidden" 
				name="image_id" 
				value="{{ chosenImage ? chosenImage.id : null }}"
			>
		</div>
	</div>


	<!-- Modal -->
	<div class="modal fade" id="imagesModal" tabindex="-1" role="dialog" aria-labelledby="modal-title">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Choose Featured Image</h4>
				</div>
				<div class="modal-body">

					<span v-if="!images"><i class="fa fa-circle-o-notch fa-spin"></i> Fetching Images</span>

					<div class="row" v-if="images">
						<p class="col-xs-12">
							Page {{ page }} of {{ lastPage }}
						</p>
						<div class="col-xs-3 top-buffer" v-for="image in images">

							<img  @click="selectImage(image)" class="img-responsive img-thumbnail selectable" v-bind:src="image.thumbnail_url" alt="" v-bind:class="{'selected': isSelected(image)}" >

						</div>
						<p class="clearfix col-xs-12">
							<button type="button" class="btn btn-link pull-left" @click="prevPage"><i class="fa fa-chevron-left"></i> Prev</button>
							<button type="button" class="btn btn-link pull-right" @click="nextPage">Next <i class="fa fa-chevron-right"></i></button>
						</p>
					</div>
				</div>
				<div class="modal-footer">
					<span class="pull-left">{{ selectedImage ? selectedImage.title : '' }}</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal" @click="chooseImage()">Select</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	module.exports = {
		props: ['image'],

		ready: function(){
			this.fetchChosenImage();
		},

		data: function() {
			return {
				selectedImage: null,
				chosenImage: null,
				page: 1,
				lastPage: null,
				images: null,
			};
		},

		methods: {
			fetchImages: function() {
				this.images = null;
				this.$http.get('/api/images', {page: this.page})
				.success(function(response) {
					this.images = response.data
					this.lastPage = response.last_page;
				}.bind(this));
			},
			fetchChosenImage: function() {
				if (this.image) {
				this.$http.get('/api/images/' + this.image)
					.success(function(response) {
						this.chosenImage = response;
					}.bind(this));
				}
			},

			selectImage: function(image, e) {
				this.selectedImage = image;
			},
			chooseImage: function() {
				this.chosenImage = this.selectedImage;
				this.selectedImage = {};
			},
			isSelected: function(image) {
				return this.selectedImage ? this.selectedImage.id == image.id : false;
			},

			nextPage: function() {
				console.log("incrementing page");
				if (this.page < this.lastPage) {
					this.page++;
					this.fetchImages();
				}
			},
			prevPage: function() {
				if(this.page > 1) {
					this.page--;
					this.fetchImages();
				}
			}
		}
	};
</script>