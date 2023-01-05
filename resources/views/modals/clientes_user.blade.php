<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    id="exampleModalXl" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog  modal-dialog-scrollable modal-xl relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div
                class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalXlLabel">
                    CLientes do Usuario
                </h5>
                <div class="self-end">
                    <a class="inline-block px-4 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg  focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out mr-1.5"
                        data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                        aria-controls="clientEdit">
                        + Cliente
                    </a>
                </div>
                @include('modals.cliente_add');
                @include('modals.client_edit')
                <button type="button"
                    class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body relative p-4 ">
                <table
                    class="display" id="example" >
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class=" w-1/6 py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                Dados
                            </th>

                            <th scope="col"
                                class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                Game BOT
                            </th>
                            <th scope="col"
                                class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                Inicio
                            </th>
                            <th scope="col"
                                class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                termino
                            </th>

                            <th scope="col"
                                class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                status
                            </th>
                            <th scope="col"
                                class="py-3 px-4 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                Apagar
                            </th>
                            </th>

                        <tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                        id="user-clients-table">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{--


















    <x-bladewind.modal size="xl" title="Clientes do Usuario" name="xl-modal"
    class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto">
    <div id="modal_content">


        <button
            class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full">+ Cliente
        </button>

        <div class="panel">


        </div>
        <br>
        <br>
        <div class="flex flex-col  overflow-y-scroll overflow-x-scroll">
            <div class=" shadow-md sm:rounded-lg ">
                <div class="inline-block min-w-full align-middle ">
                    <div class="overflow-hidden ">

                    </div>
                </div>

            </div>
</x-bladewind.modal> --}}
