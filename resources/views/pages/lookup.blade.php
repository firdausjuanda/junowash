@extends('layouts.default')
@section('content')
    <div class="container px-6">
        <h1
            class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
            Beyond than just Clean</h1>
        <div class="flex flex-wrap">
            <div class="sm:basis-full md:basis-1/4 md:basis-1/4 lg:basis-1/4 xl:basis-1/4">
                <div
                    class="p-4 bg-white w-min-sm border border-gray-200 m-2 rounded-lg shadow-md sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <form class="space-y-6" method="post" action="/lookup">
                        @csrf
                        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Check your transaction</h5>
                        <div>
                            <label for="input_key" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                Vehicle number or Transaction code</label>
                            <input type="text" name="input_key" id="input_key"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="BA1234CD or ABC123-XYZ456" value="{{ isset($input_key) ? $input_key : '' }}">
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">LOOK
                            UP</button>
                    </form>
                </div>
            </div>
            <div class="sm:basis-full md:basis-3/4 lg:basis-3/4 xl:basis-3/4">
                @if (Session::has('msg'))
                    <div id="alert-additional-content-3"
                        class="m-2 p-4 mb-4 border border-{{ Session::get('color') }}-300 rounded-lg bg-{{ Session::get('color') }}-50 dark:bg-{{ Session::get('color') }}-200"
                        role="alert">
                        <div class="flex items-center">
                            <svg aria-hidden="true"
                                class="w-5 h-5 mr-2 text-{{ Session::get('color') }}-700 dark:text-{{ Session::get('color') }}-800"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Info</span>
                            <h3
                                class="text-lg font-medium text-{{ Session::get('color') }}-700 dark:text-{{ Session::get('color') }}-800">
                                {{ Session::get('msg') }}</h3>
                        </div>
                    </div>
                @endif
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg m-2">
                    @if (!isset($service_list))
                        <div
                            class="p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <svg class="w-10 h-10 mb-2 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z"
                                    clip-rule="evenodd"></path>
                                <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"></path>
                            </svg>
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Need a
                                    help in Claim?</h5>
                            </a>
                            <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Go to this step by step guideline
                                process on how to certify for your weekly benefits:</p>
                            <a href="#" class="inline-flex items-center text-blue-600 hover:underline">
                                See our guideline
                                <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z">
                                    </path>
                                    <path
                                        d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    @else
                        <table class="table-auto w-full border-collapse text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        Transaction code
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        <div class="flex items-center">
                                            Vechicle Number
                                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3"
                                                    aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                                    <path
                                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z" />
                                                </svg></a>
                                        </div>
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        <div class="flex items-center">
                                            Type
                                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3"
                                                    aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                                    <path
                                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z" />
                                                </svg></a>
                                        </div>
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        <div class="flex items-center">
                                            Date
                                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3"
                                                    aria-hidden="true" fill="currentColor" viewBox="0 0 320 512">
                                                    <path
                                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z" />
                                                </svg></a>
                                        </div>
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($service_list->isEmpty())
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="py-4 px-6 text-center" colspan="5">
                                            Data not found :(
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($service_list as $service)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $service['transaction_code'] }}
                                            </th>
                                            <td class="py-4 px-6">
                                                {{ $service['vehicle_number'] }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $service['unit_type'] }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $service['created_at'] }}
                                            </td>
                                            <td class="py-4 px-6 text-right">
                                                <a href="#"
                                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    @endif
                </div>

            </div>
        </div>

    </div>
@endsection
