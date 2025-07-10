<template>
    <svg viewBox="0 0 400 600" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Main rounded rectangle border -->
        <rect
            x="60"
            y="130"
            width="280"
            height="350"
            rx="25"
            ry="25"
            fill="none"
            stroke="#2B8065"
            stroke-width="12"
        />

        <!-- Dynamic figure -->
        <g transform="translate(200, 200)">
            <!-- Head -->
            <circle cx="0" cy="-70" r="18" fill="#B8860B" />

            <!-- Left arm -->
            <path
                d="M-30 -50 L-60 -25"
                stroke="#B8860B"
                stroke-width="8"
                stroke-linecap="round"
            />

            <!-- Right arm -->
            <path
                d="M30 -50 L70 -15"
                stroke="#B8860B"
                stroke-width="8"
                stroke-linecap="round"
            />

            <!-- Body curve -->
            <path
                d="M0 -40 Q25 -20 40 10 Q45 30 35 50 Q25 70 10 85"
                stroke="#B8860B"
                stroke-width="8"
                stroke-linecap="round"
                fill="none"
            />

            <!-- Left leg -->
            <path
                d="M-10 40 Q-25 60 -35 80 Q-45 100 -55 120"
                stroke="#B8860B"
                stroke-width="8"
                stroke-linecap="round"
                fill="none"
            />

            <!-- Right leg -->
            <path
                d="M15 50 Q5 70 0 90"
                stroke="#B8860B"
                stroke-width="8"
                stroke-linecap="round"
                fill="none"
            />
        </g>

        <!-- PRIDE text -->
        <g transform="translate(85, 380)">
            <text
                x="0"
                y="0"
                font-family="Arial, sans-serif"
                font-size="48"
                font-weight="bold"
                fill="#2B8065"
            >
                <tspan x="0" dy="0">P</tspan>
                <tspan x="35" dy="0">R</tspan>
                <tspan x="75" dy="0">I</tspan>
                <tspan x="95" dy="0">D</tspan>
                <tspan x="140" dy="0">E</tspan>
            </text>
        </g>

        <!-- BANK text -->
        <g transform="translate(95, 520)">
            <text
                x="0"
                y="0"
                font-family="Arial, sans-serif"
                font-size="42"
                font-weight="bold"
                fill="#B8860B"
            >
                <tspan x="0" dy="0">B</tspan>
                <tspan x="35" dy="0">A</tspan>
                <tspan x="70" dy="0">N</tspan>
                <tspan x="105" dy="0">K</tspan>
            </text>
        </g>

        <!-- Tagline -->
        <text
            x="200"
            y="570"
            font-family="Arial, sans-serif"
            font-size="16"
            font-weight="normal"
            fill="#2B8065"
            text-anchor="middle"
        >
            Your Growth is Our Pride
        </text>
    </svg>
</template>
