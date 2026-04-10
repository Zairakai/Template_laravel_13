#!/usr/bin/env bats

@test "node_modules exists after install" {
    [ -d "node_modules" ]
}

@test "vite config is present" {
    [ -f "vite.config.ts" ]
}
