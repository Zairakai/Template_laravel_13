#!/usr/bin/env bats

@test "artisan is executable" {
  run php artisan --version
  [ "$status" -eq 0 ]
  [[ "$output" == *"Laravel"* ]]
}

@test "API v1 health route is registered" {
  run php artisan route:list --path=api/v1/health --json
  [ "$status" -eq 0 ]
  [[ "$output" == *"v1\/health"* ]]
}

@test "app config is valid" {
  run php artisan config:show app --no-interaction
  [ "$status" -eq 0 ]
}
