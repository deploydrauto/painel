  <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
      name="xl-modal" id="users_games" tabindex="-1" aria-labelledby="exampleModalXlLabel" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl relative w-auto pointer-events-none">
          <div
              class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
              <div
                  class="modal-header flex flex-end items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                  <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalXlLabel">
                      Gerenciar Games do Cliente
                  </h5>
                  <div class="self-end   pl-40">
                      <p>
                        @can('admin')
                          <select id="game_no_have">
                              <option value="null" selected disabled>Selecione</option>
                          </select>
                          <a class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg  focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out mr-1.5"
                              role="button" onclick="storeGameUser()">
                              Adicionar
                          </a>
                          @endcan
                      </p>
                  </div>

                  <button type="button"
                      class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-10 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-15 hover:no-underline"
                      data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body relative p-4">
                  <table
                      class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700 overflow-y-scroll overflow-x-scroll">
                      <thead class="bg-gray-100 dark:bg-gray-700">
                          <tr>
                              <th scope="col"
                                  class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                  id
                              </th>
                              <th scope="col"
                                  class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                  Name BOTGAME
                              </th>
                              <th scope="col"
                                  class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                  Actions
                              </th>
                              </th>

                          <tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                          id="games-user-table">
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
