<?php

use Lib\Helpers;
?>
<!DOCTYPE html>
<html
	lang="en"
	class="dark">

<head>
	<title>Page Not Found</title>

	<meta charset="utf-8" />
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1" />

	<link rel="stylesheet" href="/dist/main.css" />
</head>

<body class="bg-gray-950 min-h-dvh text-white">
	<section
		class="flex items-center justify-center flex-col h-full max-h-dvh p-16 text-gray-400">
		<div
			class="container flex flex-col items-center justify-center px-5 mx-auto my-8">
			<div class="max-w-md text-center">
				<h2 class="mb-8 font-extrabold text-9xl text-gray-400">
					<span class="sr-only">Error</span>404
				</h2>
				<p class="text-2xl font-semibold md:text-3xl">
					Sorry, we couldn't find this page.
				</p>
				<p class="mt-4 mb-8 text-gray-600">
					But dont worry, you can find plenty of other things on
					our homepage.
				</p>
				<a
					href="<?= Helpers::route('product.index') ?>"
					class="px-8 py-3 font-semibold rounded bg-blue-600 text-gray-50">Back to homepage</a>
			</div>
		</div>
	</section>
</body>

</html>
