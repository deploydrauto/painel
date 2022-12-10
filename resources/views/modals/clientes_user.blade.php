<x-bladewind.modal size="xl" title="Clientes do Usuario" name="xl-modal" class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="modal_clientes">
    <div id="modal_content">


        <button class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full">Cadastrar Novo Us</button>

        <div class="panel">


    </div>
    <br>
    <br>
    <div class="flex flex-col  overflow-y-scroll overflow-x-scroll">
        <div class=" shadow-md sm:rounded-lg ">
            <div class="inline-block min-w-full align-middle ">
                <div class="overflow-hidden ">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700 overflow-y-scroll overflow-x-scroll">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                    Cliente
                                </th>
                                <th scope="col"
                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                    email
                                </th>
                                <th scope="col"
                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                    Telefone
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
                        </tbody>
                    </table>
                </div>
            </div>




        </div>
</x-bladewind.modal>
