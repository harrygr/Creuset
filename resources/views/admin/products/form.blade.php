
<div class="form-group col-md-8">
	<div class="panel panel-default" id="postContent">
		<div class="panel-body">
			<cr-title-slugger name="name" value="{{ old('name', $product->name) }}" slug="{{ old('slug', $product->slug) }}"></cr-title-slugger>

			<cr-markarea value="{{ old('description', $product->description) }}" name="description" title="description"></cr-markarea>

		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="panel panel-default" id="postContent">
		<div class="panel-body">
			<div class="form-group">
				{!! Form::label('published_at', 'Publish At') !!}
				<div class="date">
					{!! Form::input('datetime-local', 'published_at', old('published_at', isset($product->published_at) ? $product->published_at->format('Y-m-d\TH:i:s') : date('Y-m-d\TH:i:s')), ['class' => 'form-control']) !!}
				</div>
			</div>


			<div class="form-group">
				<label for="price">Price</label>
				<input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $product->price) }}">
			</div>	

			<div class="form-group">
				<label for="sale_price">Sale Price</label>
				<input type="number" step="0.01" class="form-control" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}">
			</div>

			<div class="form-group">
				<label for="name">Stock Quantity</label>
				<input type="number" class="form-control" name="stock_qty" value="{{ old('stock_qty', $product->stock_qty) }}">
			</div>

			<div class="form-group">
				<label for="name">SKU</label>
				<input type="text" class="form-control" name="sku" value="{{ old('sku', $product->sku) }}">
			</div>

			<div class="form-group">
				{!! Form::label('user_id', 'Author') !!}
				{!! Form::select('user_id', Creuset\User::lists('name', 'id'), null, ['class' => 'form-control']) !!}
			</div>

			<div class="">
				<input type="submit" class="btn btn-primary">
			</div>
		</div>
	</div>

	<cr-category-chooser taxonomy="product_category" heading="Product Categories" :checkedcategories="{{ isset($selected_product_categories) ? $selected_product_categories->toJson(JSON_NUMERIC_CHECK) : '[]' }}"></cr-category-chooser>

	<cr-image-chooser image="{{ old('media_id', $product->media_id) }}"></cr-image-chooser>
	</div>


