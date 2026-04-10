#!/usr/bin/env bats

@test "bash is available" {
    run bash --version
    [ "$status" -eq 0 ]
}

@test "project root contains package.json" {
    [ -f "package.json" ]
}
