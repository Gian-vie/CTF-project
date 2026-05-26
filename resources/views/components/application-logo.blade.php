<svg viewBox="60 30 392 430" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
  <defs>
    <!-- Neon -->
    <linearGradient id="neon" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#ff66ff"/>
      <stop offset="100%" stop-color="#8a2be2"/>
    </linearGradient>

    <!-- Glow -->
    <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
      <feGaussianBlur stdDeviation="6" result="blur"/>
      <feMerge>
        <feMergeNode in="blur"/>
        <feMergeNode in="SourceGraphic"/>
      </feMerge>
    </filter>

    <!-- Circuitos -->
    <pattern id="circuit" width="40" height="40" patternUnits="userSpaceOnUse">
      <path d="M0 20 H20 V40" stroke="#331144" stroke-width="1" fill="none"/>
      <circle cx="20" cy="20" r="2" fill="#552266"/>
    </pattern>
  </defs>
  <!-- Escudo mais baixo/largo -->
  <path d="
    M256 70
    L400 110
    L385 235
    C372 320 315 385 256 425
    C197 385 140 320 127 235
    L112 110
    Z"
    fill="none"
    stroke="url(#neon)"
    stroke-width="10"
    filter="url(#glow)"
  />

  <!-- Escudo interno -->
  <path d="
    M256 92
    L375 125
    L363 230
    C352 300 304 355 256 390
    C208 355 160 300 149 230
    L137 125
    Z"
    fill="rgba(255,255,255,0.02)"
    stroke="#cc66ff"
    stroke-width="2"
    opacity="0.85"
  />

  <!-- ADS -->
  <text x="256" y="245"
        text-anchor="middle"
        font-family="Arial, sans-serif"
        font-size="76"
        font-weight="bold"
        fill="#f5b8ff"
        filter="url(#glow)">
    ADS
  </text>

</svg>
