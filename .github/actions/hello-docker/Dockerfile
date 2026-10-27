FROM alpine:3.18
COPY entrypoint.sh /entrypoint.sh
COPY cleanup.sh /cleanup.sh
RUN chmod +x /entrypoint.sh /cleanup.sh
ENTRYPOINT ["/entrypoint.sh"]  # This defines the executable Docker starts when the container runs.
CMD ["World-Cmd"]  # This provides the default argument to the entrypoint.



# If you run the image without supplying other arguments, Docker effectively executes:- /entrypoint.sh World

# Important: GitHub Actions' runs.args replaces the Dockerfile's default CMD arguments. In your action, GitHub passes the configured greeting input instead