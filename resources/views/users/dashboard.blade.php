<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

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
                                                                <x-primary-button data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalXl"
                                                                    onClick="fetchUserClients({{ $user->id }})" class="mt-1">
                                                                    Clientes: T:{{ $user->clientes }} A:  {{ $user->ativos }}  I:  {{ $user->inativos }}
                                                                </x-primary-button>

                                                            </p>
                                                            <p>
                                                                <x-primary-button class="mt-1" data-bs-toggle="modal"
                                                                    data-bs-target="#users_games"
                                                                    onClick="fetchGamesUser({{ $user->id }})"> Games :
                                                                    {{ $user->games }}
                                                                </x-primary-button>
                                                            </p>
                                                            <p>
                                                                <x-primary-button class="mt-1"   data-bs-toggle="modal"
                                                                data-bs-target="#webhooks_modal" onclick="fetchWebhooksUser({{ $user->id }})"> WebHooks : {{ $user->webhooks }}
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

                    @include('modals.user_add')
                    @include('modals.clientes_user')
                    @include('modals.games_user')
                    @include('modals.webhooks_user')





                </div>
            </div>
        </div>
    </div>
</x-app-layout>
