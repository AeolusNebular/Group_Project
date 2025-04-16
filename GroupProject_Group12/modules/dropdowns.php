<?php
    
    // 📅 Year dropdown
    function populateYearDropdown($selectedYear, $name = "year") {
        $years = ['2016', '2017', '2018', '2019', '2020'];
        foreach ($years as $year) {
            $selected = ($year == $selectedYear) ? 'selected' : '';
            echo "<option value=\"$year\" $selected>$year</option>";
        }
    }
    
    // 🌐 Network dropdown
    function populateNetworkDropdown($selectedNetwork, $name = "network") {
        $networks = [
            'coteq' => 'Coteq',
            'westland-infra' => 'Westlandia',
            'enexis' => 'Enexis',
            'stedin' => 'Stedin',
            'liander' => 'Liander'
        ];
        foreach ($networks as $value => $label) {
            $selected = ($value === $selectedNetwork) ? 'selected' : '';
            echo "<option value=\"$value\" $selected>$label</option>";
        }
    }
    
    // 🔌 Utility dropdown
    function populateUtilityDropdown($selectedType, $name = "type") {
        foreach (['Electricity', 'Gas'] as $type) {
            $selected = ($type === $selectedType) ? 'selected' : '';
            echo "<option value=\"$type\" $selected>$type</option>";
        }
    }
    
?>