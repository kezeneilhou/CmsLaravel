<x-dashboard-layout>
    <div class="mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-xl font-bold mb-4">Add New Post</h2>
        <!-- Form -->
        <form x-data="{ type: '{{ isset($post) ? $post->type : '' }}' }" method="Post"
            action="{{ isset($post) ? route('post.update', $post->id) : route('post.store') }}" class="space-y-6"
            enctype="multipart/form-data">
            @method(isset($post) ? 'PUT' : 'POST')
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="col-span-3">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700">Title</label>
                        <input type="text" id="title" name="title" required
                            value="{{ isset($post) ? $post->title : '' }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-300 focus:border-indigo-300">
                    </div>
                    <div x-show="type === 'Post'" x-cloak class="mt-3">
                        <label for="content" class="block text-sm font-semibold text-gray-700">Content</label>
                        <div id="editor">
                        </div>
                    </div>
                    <input type="hidden" name="content" id="content">
                    <div x-show="type === 'File'" x-cloak>
                        <label for="file" class="block text-sm font-semibold text-gray-700">Upload File</label>
                        <input type="file" id="file" name="file"
                            class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200">
                    </div>

                    <div x-show="type === 'Link'" x-cloak>
                        <label for="link" class="block text-sm font-semibold text-gray-700">Link URL</label>
                        <input type="url" id="link" name="link"
                            class="mt-1 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-300 focus:border-indigo-300">
                    </div>
                </div>
                <div>
                    <div>
                        <label for="type" class="block text-sm font-semibold text-gray-700">Category</label>
                        <select id="type" name="type" x-model="type" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-300 focus:border-indigo-300">
                            <option value="" disabled>Select Type</option>
                            <option value="Post">Post</option>
                            <option value="File">File</option>
                            <option value="Link">Link</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="type" class="block text-sm font-semibold text-gray-700">Type</label>
                        <select id="type" name="type" x-model="type" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-300 focus:border-indigo-300">
                            <option value="" disabled>Select Type</option>
                            <option value="Post">Post</option>
                            <option value="File">File</option>
                            <option value="Link">Link</option>
                        </select>
                    </div>

                    <!-- Date -->
                    <div class="mt-3">
                        <label for="date" class="block text-sm font-semibold text-gray-700">Date</label>
                        <input type="date" id="date" name="date" required
                            value="{{ isset($post) ? $post->date : '' }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-300 focus:border-indigo-300">
                    </div>
                    <button type="submit"
                        class="w-full mt-5 py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-500 focus:ring focus:ring-indigo-300">
                        {{ isset($post) ? 'Update Post' : 'Publish Post' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
    <style>
        #editor {
            height: 300px;
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: {
                        container: [
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            ['bold', 'italic', 'underline'],
                            ['link', 'image', 'video'],
                            ['file', 'custom-file'], // Custom file upload button
                        ],
                        handlers: {
                            'file': function() {
                                var input = document.createElement('input');
                                input.setAttribute('type', 'file');
                                input.setAttribute('accept',
                                    '.pdf,.doc,.docx,.txt'); // Allow specific file types
                                input.click();

                                input.onchange = async function() {
                                    var file = input.files[0];
                                    if (file) {
                                        var formData = new FormData();
                                        formData.append('file', file);
                                        try {
                                            const response = await fetch('/upload-file', {
                                                method: 'POST',
                                                body: formData,
                                                headers: {
                                                    'X-CSRF-TOKEN': document
                                                        .querySelector(
                                                            'meta[name="csrf-token"]')
                                                        .content
                                                }
                                            });
                                            const data = await response.json();
                                            const range = quill.getSelection();
                                            quill.insertText(range.index, file.name, {
                                                link: data.url
                                            });
                                        } catch (error) {
                                            console.error("Image upload failed:", error);
                                        }
                                    }
                                };
                            }
                        }
                    }
                }
            });
            // custome icon for toolbar
            var customButton = document.querySelector('.ql-file');
            if (customButton) {
                customButton.innerHTML = '<i class="fas fa-file-upload"></i>'; // FontAwesome icon for file upload
            }

            @if (isset($post))
                var content = {!! json_encode($post->content) !!}; // Escapes the content safely
                quill.root.innerHTML = content;
            @endif
            // Custom image handler for uploads (as previously set up)
            quill.getModule('toolbar').addHandler('image', function() {
                let input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.click();

                input.onchange = async function() {
                    let file = input.files[0];
                    if (file) {
                        let formData = new FormData();
                        formData.append('image', file);

                        try {
                            const response = await fetch('/upload-image', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content
                                }
                            });
                            const data = await response.json();
                            const range = quill.getSelection();
                            quill.insertEmbed(range.index, 'image', data.url);
                        } catch (error) {
                            console.error("Image upload failed:", error);
                        }
                    }
                };
            });
            quill.on('text-change', function(delta, oldDelta, source) {
                var content = document.querySelector('input[name=content]');
                content.value = quill.root.innerHTML;
            })
        });
    </script>

</x-dashboard-layout>
