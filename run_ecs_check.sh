#!/bin/bash

#
# Run the code style checker on project source
#
# Run examples
#
#   a) Just check the code style errors
#       ./run_ecs_check.sh
#
#   b) Fix the style errors
#       ./run_ecs_check.sh --fix


DOCKER_CMD=$(which docker)

$DOCKER_CMD run \
    --rm \
    -it \
    --entrypoint sh \
    -v $(pwd):/var/www \
    jakzal/phpqa:1.18.0-php7.2-alpine \
    -c "cd /var/www && ecs check src/ $@; exit"

echo "Done!"
