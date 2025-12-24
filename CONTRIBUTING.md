# Contributing to KaijuTranslator 🦖

Thank you for considering contributing to KT! We want to make contributing as easy and transparent as possible.

## Development Environment Setup

1. **Clone the repo**:

   ```bash
   git clone https://github.com/branvan3000/KaijuTranslator.git
   cd KaijuTranslator
   ```

2. **Docker Demo (Recommended)**:
   The easiest way to see changes in action is using the provided Docker environment:

   ```bash
   docker compose up -d
   ```

   Visit `http://localhost:8080` to see the example site.

3. **Running Tests**:
   Before submitting a PR, ensure all tests pass:

   ```bash
   php KT/tests/run_tests.php
   ```

## Pull Request Process

1. Fork the repository and create your branch from `main`.
2. If you've added code that should be tested, add tests.
3. If you've changed APIs, update the documentation.
4. Ensure the test suite passes.
5. Issue that PR!

## Code Style

Please follow PSR-12 coding standards. We use 4 spaces for indentation.

## Any questions?

Feel free to open an issue for discussion before starting work on a major feature.
