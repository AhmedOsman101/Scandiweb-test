<?php

use Lib\Helpers;

$title = $nav_title = "Add Product";

include "partials/header.php";
include "partials/body.php";
?>

<main class="grid mt-8 px-3">
	<form
		x-data="{
				Type: 'DVD',
				SKU: '',
				Name: '',
				Price: 0,
				Size: null,
				Weight: null,
				Width: null,
				Height: null,
				Length: null,
				}"
		class="flex flex-col gap-8 px-5"
		id="product_form"
		action="<?= Helpers::route('product.store') ?>"
		method="post">
		<label
			for="sku"
			class="">
			<span>SKU</span>
			<input
				x-model="SKU"
				type="text"
				id="sku"
				class="bg-gray-800 rounded-md px-3 py-1"
				name="sku"
				placeholder="SKU" />
		</label>

		<label
			for="name"
			class="">
			<span>Name</span>
			<input
				x-model="Name"
				type="text"
				id="name"
				class="bg-gray-800 rounded-md px-3 py-1"
				name="name"
				placeholder="Name" />
		</label>

		<label for="price">
			<span>Price</span>
			<div class="flex">
				<span
					class="flex items-center px-3 pointer-events-none sm:text-sm rounded-l-md bg-gray-700">
					$
				</span>
				<input
					x-model="Price"
					type="number"
					min="0"
					name="price"
					id="price"
					placeholder="price"
					class="flex flex-1 sm:text-sm rounded-r-md bg-gray-800" />
			</div>
		</label>

		<fieldset>
			<label for="productType">
				<span>Type</span>

				<select
					x-model="Type"
					type="number"
					id="productType"
					class="bg-gray-800 rounded-md px-3 py-2"
					name="type">
					<option value="DVD">DVD</option>
					<option value="Book">Book</option>
					<option value="Furniture">Furniture</option>
				</select>
			</label>
		</fieldset>

		<fieldset
			x-show="Type === 'DVD'"
			x-transition.opacity.duration.500ms
			id="DVD"
			class="space-y-5 flex flex-col">
			<label for="size">
				<span>Size</span>

				<div class="flex">
					<input
						x-model="Size"
						type="number"
						min="0"
						name="size"
						id="size"
						placeholder="size"
						class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
					<span
						class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
						MB
					</span>
				</div>
			</label>

			<li>
				<span class="text-sm text-gray-500">
					Please provide a valid size for the DVD in
					Megabytes.
				</span>
			</li>
		</fieldset>

		<fieldset
			x-show="Type === 'Book'"
			x-transition.opacity.duration.500ms
			id="Book"
			class="space-y-5 flex flex-col">
			<label for="weight">
				<span>Weight</span>

				<div class="flex">
					<input
						x-model="Weight"
						type="number"
						min="0"
						name="weight"
						id="weight"
						placeholder="weight"
						class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
					<span
						class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
						KG
					</span>
				</div>
			</label>

			<li>
				<span class="text-sm text-gray-500">
					Please provide a valid weight for the Book in
					Kilograms.
				</span>
			</li>
		</fieldset>

		<fieldset
			x-show="Type === 'Furniture'"
			x-transition.opacity.duration.500ms
			id="Furniture"
			class="space-y-5 flex flex-col">
			<label for="height">
				<span>Height</span>

				<div class="flex">
					<input
						x-model="Height"
						type="number"
						min="0"
						name="height"
						id="height"
						placeholder="height"
						class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
					<span
						class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
						CM
					</span>
				</div>
			</label>

			<label for="width">
				<span>Width</span>

				<div class="flex">
					<input
						x-model="Length"
						type="number"
						min="0"
						name="width"
						id="width"
						placeholder="width"
						class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
					<span
						class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
						CM
					</span>
				</div>
			</label>
			<label for="length">
				<span>Length</span>

				<div class="flex">
					<input
						x-model=""
						type="number"
						min="0"
						name="length"
						id="length"
						placeholder="length"
						class="flex flex-1 sm:text-sm rounded-l-md bg-gray-800" />
					<span
						class="flex items-center px-3 pointer-events-none sm:text-sm rounded-r-md bg-gray-700">
						CM
					</span>
				</div>
			</label>

			<li>
				<span class="text-sm text-gray-500">
					Please provide valid dimensions for the furniture in
					the form of height, width and length in Centimeters.
				</span>
			</li>
		</fieldset>
	</form>
</main>

<?php include "partials/footer.php" ?>
