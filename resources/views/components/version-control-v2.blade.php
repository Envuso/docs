{{--<b class="text-purple-400 pt-3 pl-6">Version:</b>--}}
<div class="flex flex-col items-center justify-center mt-4 px-4">

    <button type="button"
            class="border border-gray-800 flex justify-center transition w-full rounded-md shadow-sm py-2 bg-gray-900 text-sm font-medium text-purple-400 outline-none focus:outline-none dropdown-toggle">
        Version: <strong class="ml-1 text-purple-300">V2.X</strong>
        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
             aria-hidden="true">
            <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"/>
        </svg>
    </button>
    <!-- Remove hidden class when dropdown is visible -->
    <div
        class="hidden flex rounded-lg shadow-2xl overflow-hidden flex-col items-center w-full mt-2 relative focus:outline-none transition ease-out duration-100"
        id="dropdown-menu">
        <div class="flex flex-col items-center w-full">
            <a href="{{ url("/v1/setup") }}"
               class=" py-2 font-medium transition flex flex-row items-center justify-center w-full bg-gray-800 text-white text-sm hover:bg-gray-700 hover:text-purple-400 hover:font-bold">V1.X</a>
            <a href="{{ url("/v2/setup") }}"
               class=" py-2 font-medium transition flex flex-row items-center justify-center w-full bg-gray-700 text-white text-sm hover:bg-gray-900 hover:text-purple-400 hover:font-bold">V2.X</a>
        </div>
    </div>

</div>
