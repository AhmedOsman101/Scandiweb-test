<?php

use App\Helpers;
?>
<button
  class="bg-gray-600 rounded-sm px-3 py-1.5 hover:bg-blue-600 transition-colors duration-300">
  Save
</button>
<a
  href="<?= Helpers::route('product.index') ?>"
  class="bg-gray-600 rounded-sm px-3 py-1.5 hover:bg-red-800 transition-colors duration-300">
  Cancel
</a>
