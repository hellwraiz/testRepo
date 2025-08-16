<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exam thing</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen ">
    <div id="app" class="flex p-8 flex-col items-center justify-center bg-[#f0f0f0]">
        <h1 class="flex w-3xl text-5xl">Надіслати резюме</h1>
        <form id="ResumeUpload" class="flex w-3xl flex-col mt-5 gap-2">
            
            <div>
                <text-input v-model="name" :error="errorMessage"/>
            </div>
            
            <div>
                <email-input v-model="email" :error="errorMessage"/>
            </div>
            
            <div>
                <phone-input :error="errorMessage" @country-change="handleCountryChange"/>
            </div>

            <div>
                <message-input v-model="message" :error="errorMessage"/>
            </div>

            <div class="flex justify-between">

                <div class="flex">
                    <div class="rounded-l border border-[#d1d1d1] p-4 bg-white flex-shrink">
                        <input class="scale-150" type="checkbox" v-model="checkbox">
                    </div>
                    
                    <div :class="{'opacity-50 cursor-not-allowed': !checkbox , 'border border-red-500': errorMessage && checkbox && !imageUploaded}" class="rounder-r flex p-4 bg-white border border-[#D1D1D1]">
                        <input id="fileInput" class="hidden" type="file" accept="image/*" @change="handleFileUpload" :disabled="!checkbox">
                        <label for="fileInput" class="cursor-pointer"> Choose File </label>
                    </div>
                    <span class="p-4">
                        <template v-if="imageUploaded && checkbox">@{{ imageUploaded.name }}</template>
                    </span>
                    <span v-if="errorMessage" class="p-4 text-red-500">
                        @{{ errorMessage }}
                    </span>
                    <span v-if="successMessage" class="p-4 text-green-700">
                        @{{ successMessage }}
                    </span>
                </div>


                <button type="button" @click="submitForm()" :disabled="tryingToSubmit" :class="{'bg-gray-500': tryingToSubmit}" class="cursor-pointer border rounded border-[#D1D1D1] p-4 text-white bg-[#2B2C38]">Submit</button>

            </div>
        </form>
    </div>
</body>
</html>