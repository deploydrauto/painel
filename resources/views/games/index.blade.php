<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        {{-- align x-primary-button  from right --}}
        <div class="flex justify-end">
            <x-primary-button class="mt-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop">{{ __('Adicionar') }}
            </x-primary-button>
        </div>
        <table
            class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700 overflow-y-scroll overflow-x-scroll">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                        BOTGAME
                    </th>
                    <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                        Status
                    </th>
                    <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                        Estatisticas
                    </th>

                    <th scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                        Actions
                    </th>
                    </th>

                <tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                id="user-clients-table">
                @foreach ($games as $game)
                <tr>
                    <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                        {{ $game->name }}</td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                        {{ $game->status == 1 ? 'Ativo' : 'Desativado' }}</td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                        <p>Admins : {{ $game->admins }}</p>
                        <p>Clientes : {{ $game->clientes }}</p>
                    </td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                      
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        <!-- Modal -->
        @include('modals.create_gamebot');



</x-app-layout>
