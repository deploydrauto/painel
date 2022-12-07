<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-end">
            <x-primary-button onclick="showModal('user-create')">{{ __('+ Adicionar') }}
            </x-primary-button>
        </div>

    </x-slot>

    <div class="max-w-2xl mx-auto">

        <div class="flex flex-col">
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Usuario
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        email
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Statistic
                                    </th>


                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                        <td onClick="editUser({{ $user->id }})"
                                            class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $user->name }}
                                        </td>
                                        <td onClick="editUser({{ $user->id }})"
                                            class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                            {{ $user->email }}
                                        </td>
                                        <td
                                            class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                            <p>
                                                <x-primary-button onClick="fetchUserClients({{$user->id}})" class="mt-1">Clientes: {{ $user->clientes }}
                                                </x-primary-button>
                                            </p>
                                            <p>
                                                <x-primary-button class="mt-1"> Games : {{ $user->games }}
                                                </x-primary-button>
                                            </p>
                                            <p>
                                                <x-primary-button class="mt-1"> WebHooks : {{ $user->webhooks }}
                                                </x-primary-button>
                                            </p>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <x-bladewind.button onclick="showModal('xl-modal')">
        Xl Modal
    </x-bladewind.button>

   <x-bladewind.modal
        size="xl"
        title="XL Modal"
        name="xl-modal">
       <div id="modal_content"></div>
    </x-bladewind.modal>


    <x-bladewind.modal name="user-create" title="Cadastrar Novo" size="big" id="" ok_button_label=""
        cancel_button_label="">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">


                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-bladewind.modal>

    <x-bladewind.modal name="user-edit" title="Editar Usuario" size="big" id="" ok_button_label=""
        cancel_button_label="">
        <form id="user-edit-form" method="POST" action="{{ route('users.edit', [$user->id]) }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">


                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-bladewind.modal>

</x-app-layout>
<script>
    let modal = document.getElementById("modal");
    function modalHandler(val) {
        if (val) {
            fadeIn(modal);
        } else {
            fadeOut(modal);
        }
    }
    function fadeOut(el) {
        el.style.opacity = 1;
        (function fade() {
            if ((el.style.opacity -= 0.1) < 0) {
                el.style.display = "none";
            } else {
                requestAnimationFrame(fade);
            }
        })();
    }
    function fadeIn(el, display) {
        el.style.opacity = 0;
        el.style.display = display || "flex";
        (function fade() {
            let val = parseFloat(el.style.opacity);
            if (!((val += 0.2) > 1)) {
                el.style.opacity = val;
                requestAnimationFrame(fade);
            }
        })();
    }
</script>
<script>
    // display modal

    // replace action of form
    function editUser(id) {
        var form = document.getElementById('user-edit-form');
        fetch('/users/show/' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                form.name.value = data.name;
                form.email.value = data.email;
                form.password.value = data.password;
                form.password_confirmation.value = data.password_confirmation;
            });
        form.action = '/users/edit/' + id;


        showModal('user-edit')
    }

    
    function fetchUserClients(id) {

        fetch('/users/clientes/' + id)
            .then(response => response.json())
            .then(data => {
                <td onClick="editUser({{ $user->id }})"
                                            class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                            {{ $user->email }}
              </td>

                console.log(data);
                showModal('xl-modal');
            });
    }
</script>
