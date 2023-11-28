@extends('layouts.app')
@section('content')
    <div class="max-w-md mx-auto bg-slate-100 rounded-lg p-4 mt-12">
        <form method="post" action="/" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label for="message" class="block mb-2 text-sm font-medium text-black">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="bg-gray-50 border border-gray-300 text-gray text-sm rounded-lg focus:ring-blue-500">
                @error('title')
                    <div class="text-red-400 text-sm">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="message" class="block mb-2 text-sm font-medium text-black">Description</label>
                <textarea id="message" rows="4" name="description" value="{{ old('description') }}"
                    class="block p-2.5 w-full text-sm text-black bg-gray-100 rounded-lg border-gray-300"
                    placeholder="Leave a comment....">
</textarea>
                @error('description')
                    <div class="text-red-400 text-sm"></div>
                @enderror
            </div>
            <div>
                <input type="file" class="filepond" name="image" multiple credits="false" />
            </div>
            <button type="submit"
                class="text-white px-4 py-4 bg-blue-700 hover:bg-blue-800 focus:ring-4  focus:ring-blue-300 font-medium rounded-lg">Create</button>
        </form>

    </div>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);
        const inputElement = document.querySelector('input[type="file"]');
        // Create a FilePond instance
        FilePond.create(inputElement, {
            acceptedFileTypes: ['image/*'],
            allowImagePreview: true,
            allowImageCrop: true,
            allowImageResize: true,
            imagePreviewHeight: 170,
            imagePreviewMarkupShow: true,

        });

        FilePond.setOptions({
            server: {
                process: './upload',
                revert: '/delete',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
    </script>
@endsection
