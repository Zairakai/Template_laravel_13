#!/usr/bin/env bats

@test "artisan can list routes without DB" {
  run php artisan route:list --json
  [ "$status" -eq 0 ]
  [[ "$output" == *"v1\/health"* ]]
}

@test "artisan about exits successfully" {
  run php artisan about --no-interaction
  [ "$status" -eq 0 ]
}
