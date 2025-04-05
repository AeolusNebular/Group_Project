<!-- 🎭 Masks for colour blindness support -->
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <!-- 🔴🟢 Deuteranopia -->
    <filter id="deuteranopia">
        <feColorMatrix type="matrix" values="0.55 0.45 0    0 0
                                                0.6  0.4  0    0 0
                                                0    0.3  0.7  0 0
                                                0    0    0    1 0" />
    </filter>
    <!-- 🔵🟡 Tritanopia -->
    <filter id="tritanopia">
        <feColorMatrix type="matrix" values="0.9   0.1   0     0 0
                                                0     0.4   0.6   0 0
                                                0     0.5   0.5   0 0
                                                0     0     0     1 0" />
    </filter>
    <!-- ⚫⚪ Achromatopsia -->
    <filter id="achromatopsia">
        <feColorMatrix type="matrix" values="0.5   0.5   0     0 0
                                                0.5   0.5   0     0 0
                                                0.5   0.5   0     0 0
                                                0     0     0     1 0" />
    </filter>
</svg>