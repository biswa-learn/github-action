#!/bin/sh
echo "::debug::Running entrypoint.sh"
echo "Hello $1"
echo "INPUT_WHO_TO_GREET: $INPUT_WHO_TO_GREET"
# If you did not set INPUT_WHO_TO_GREET as envronment variable, you can still access it as an input parameter (docker set inputs.who_to_greet as env variable)
echo "HELLO: $HELLO"
time=$(date)
echo "time=$time" >> $GITHUB_OUTPUT
echo "HELLO_TIME=$time" >> $GITHUB_ENV

# Because GitHub Actions automatically creates an INPUT_ environment variable for each action input. You don't need to declare it manually in runs.env.