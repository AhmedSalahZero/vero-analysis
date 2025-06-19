<style>

        .repeater-btn {
            cursor: pointer;
            margin-right: 10px;
        }
        .repeater-btn:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }
        .repeater-row {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .delete-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .delete-button:hover:not(:disabled) {
            background-color: #cc0000;
        }
</style>

{{-- {{ dd($financialInstitutionBanks) }} --}}
 <div id="repeater-container">
        <div class="repeater-row d-flex align-items-center" data-first="true">
            <div class="col-md-3">
				<label for="">{{ __('Chart of Account Number') }} @include('star')</label>
				<input type="text" class="code-input form-control" name="odoo_code" placeholder="{{ __('Odoo Code') }}">
			</div>
            <div class="col-md-6">
			<label for="">{{ __('Bank') }} @include('star')</label>
			<select class="bank-select form-control">
                <option value="all">All</option>
                @foreach($financialInstitutionBanks as $financialInstitutionBank)
				  <option value="{{ $financialInstitutionBank->id }}" 
											{{-- {{ isset($model) && $model->getCashInBankReceivingBankId() == $financialInstitutionBank->id ? 'selected' : '' }} --}}
											>{{ $financialInstitutionBank->getName() }}</option>
				@endforeach 
            </select>
			</div>
            <button type="button" class="repeater-button btn btn-primary repeater-btn">{{ __('Repeat') }}</button>
        </div>
    </div>
	
	

@push('js_end')
	
	  <script>
        // Track selected banks across all rows
        let selectedBanks = [];

        function initializeRow(row, index) {
            const bankSelect = row.querySelector('.bank-select');
            const codeInput = row.querySelector('.code-input');
            const repeaterButton = row.querySelector('.repeater-button');
            const deleteButton = row.querySelector('.delete-button');
            const isFirstRow = row.dataset.first === 'true';

            // Store current selected value to preserve it
            const currentValue = bankSelect.value;

            // Set name attributes
            bankSelect.name = `bank[${index}]`;
            codeInput.name = `code[${index}]`;

            // Remove existing event listeners by cloning elements
            const newBankSelect = bankSelect.cloneNode(true);
            const newRepeaterButton = repeaterButton.cloneNode(true);
            const newDeleteButton = deleteButton ? deleteButton.cloneNode(true) : null;
            bankSelect.replaceWith(newBankSelect);
            repeaterButton.replaceWith(newRepeaterButton);
            if (deleteButton && newDeleteButton) {
                deleteButton.replaceWith(newDeleteButton);
            }

            // Reassign variables after cloning
            const updatedBankSelect = row.querySelector('.bank-select');
            const updatedRepeaterButton = row.querySelector('.repeater-button');
            const updatedDeleteButton = row.querySelector('.delete-button');

            // Restore selected value
            if (updatedBankSelect.querySelector(`option[value="${currentValue}"]`)) {
                updatedBankSelect.value = currentValue;
            } else if (updatedBankSelect.options.length > 0) {
                updatedBankSelect.value = updatedBankSelect.options[0].value;
            }

            // Update selected banks list
            if (updatedBankSelect.value !== 'all' && !selectedBanks.includes(updatedBankSelect.value)) {
                selectedBanks.push(updatedBankSelect.value);
            }

            // Update repeater button state
            updatedRepeaterButton.disabled = updatedBankSelect.value === 'all';

            // Handle bank selection change
            updatedBankSelect.addEventListener('change', () => {
                updatedRepeaterButton.disabled = updatedBankSelect.value === 'all';
                // Update selected banks list
                selectedBanks = Array.from(document.querySelectorAll('.bank-select'))
                    .map(select => select.value)
                    .filter(value => value !== 'all');
            });

            // Handle repeater button click
            updatedRepeaterButton.addEventListener('click', () => {
                if (updatedBankSelect.value !== 'all') {
                    addNewRow(updatedBankSelect.value);
                    const allOption = updatedBankSelect.querySelector('option[value="all"]');
                    if (allOption) {
                        allOption.remove();
                    }
                }
            });

            // Handle delete button click
            if (updatedDeleteButton) {
                updatedDeleteButton.addEventListener('click', () => {
                    // Remove the bank from selectedBanks
                    const bankValue = updatedBankSelect.value;
                    selectedBanks = selectedBanks.filter(bank => bank !== bankValue);
                    row.remove();
                    updateRows();
                });
            }
        }

        function addNewRow(selectedBank) {
            const container = document.getElementById('repeater-container');
            const firstRow = document.querySelector('.repeater-row[data-first="true"]');
            const newRow = firstRow.cloneNode(true);

            // Configure new row
            newRow.removeAttribute('data-first');
            const bankSelect = newRow.querySelector('.bank-select');
            const allOption = bankSelect.querySelector('option[value="all"]');
            if (allOption) {
                allOption.remove();
            }

            // Remove all previously selected banks
            selectedBanks.forEach(bank => {
                const option = bankSelect.querySelector(`option[value="${bank}"]`);
                if (option) {
                    option.remove();
                }
            });

            // Explicitly select the first available option
            if (bankSelect.options.length > 0) {
                bankSelect.selectedIndex = 0;
                selectedBanks.push(bankSelect.value);
            }

            // Clear the code input
            newRow.querySelector('.code-input').value = '';

            // Add delete button if not first row
            if (!newRow.querySelector('.delete-button')) {
                const deleteButton = document.createElement('button');
                deleteButton.className = 'delete-button btn';
                deleteButton.textContent = 'Delete';
                newRow.appendChild(deleteButton);
            }

            container.appendChild(newRow);
            updateRows();
        }

        function updateRows() {
            const rows = document.querySelectorAll('.repeater-row');
            rows.forEach((row, index) => {
                initializeRow(row, index);
            });
            // Add "All" option to the first row if only one row exists
            if (rows.length === 1) {
                const bankSelect = rows[0].querySelector('.bank-select');
                if (!bankSelect.querySelector('option[value="all"]')) {
                    const newAllOption = document.createElement('option');
                    newAllOption.value = 'all';
                    newAllOption.textContent = 'All';
                    bankSelect.insertBefore(newAllOption, bankSelect.firstChild);
                    rows[0].querySelector('.repeater-button').disabled = bankSelect.value === 'all';
                }
            }
        }

        // Initialize all rows on page load
        updateRows();
    </script>
	
@endpush
