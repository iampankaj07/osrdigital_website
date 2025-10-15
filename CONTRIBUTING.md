# Contributing to OSR Digital

Thank you for your interest in contributing to OSR Digital! We welcome contributions from the community and appreciate your help in making this project better.

## 🤝 How to Contribute

### Reporting Issues

Before creating an issue, please:
1. Check if the issue already exists
2. Use the latest version of the project
3. Provide detailed information about the problem

When creating an issue, please include:
- **Description**: Clear description of the problem
- **Steps to Reproduce**: Step-by-step instructions
- **Expected Behavior**: What should happen
- **Actual Behavior**: What actually happens
- **Environment**: OS, PHP version, Laravel version, etc.
- **Screenshots**: If applicable

### Suggesting Features

We welcome feature suggestions! Please:
1. Check if the feature has been requested before
2. Provide a clear description of the feature
3. Explain why it would be useful
4. Consider the impact on existing functionality

### Code Contributions

#### Getting Started

1. **Fork the repository**
   ```bash
   git clone https://github.com/your-username/osr-digital.git
   cd osr-digital
   ```

2. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

4. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run tests**
   ```bash
   php artisan test
   ```

#### Development Guidelines

##### Code Style
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Keep functions small and focused

##### Database Changes
- Always create migrations for database changes
- Include rollback functionality
- Test migrations on fresh database
- Update seeders if needed

##### Frontend Development
- Follow React best practices
- Use functional components with hooks
- Implement proper error handling
- Ensure responsive design
- Add loading states and skeleton loaders

##### Testing
- Write tests for new features
- Ensure all tests pass
- Test both success and error scenarios
- Update existing tests if needed

#### Pull Request Process

1. **Update your branch**
   ```bash
   git checkout main
   git pull origin main
   git checkout your-feature-branch
   git rebase main
   ```

2. **Run tests and checks**
   ```bash
   php artisan test
   npm run build
   php artisan config:cache
   ```

3. **Commit your changes**
   ```bash
   git add .
   git commit -m "Add: descriptive commit message"
   ```

4. **Push to your fork**
   ```bash
   git push origin your-feature-branch
   ```

5. **Create a Pull Request**
   - Provide a clear title and description
   - Reference any related issues
   - Include screenshots if applicable
   - Ensure all checks pass

## 📋 Pull Request Template

```markdown
## Description
Brief description of the changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Tests pass locally
- [ ] New tests added for new functionality
- [ ] Manual testing completed

## Checklist
- [ ] Code follows project style guidelines
- [ ] Self-review completed
- [ ] Documentation updated
- [ ] No breaking changes (or documented)
```

## 🏗️ Development Setup

### Prerequisites
- PHP 8.1+
- Composer
- Node.js 18+
- MySQL 8.0+ or PostgreSQL 13+
- Git

### Local Development

1. **Clone and setup**
   ```bash
   git clone https://github.com/your-username/osr-digital.git
   cd osr-digital
   composer install
   npm install
   ```

2. **Environment configuration**
   ```bash
   cp .env.example .env
   # Edit .env with your database settings
   php artisan key:generate
   ```

3. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Start development servers**
   ```bash
   # Terminal 1: Laravel server
   php artisan serve
   
   # Terminal 2: Frontend development
   npm run dev
   
   # Terminal 3: Queue worker (optional)
   php artisan queue:work
   ```

### Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=TestName

# Run with coverage
php artisan test --coverage

# Frontend tests
npm test
```

## 📝 Documentation

When contributing, please update documentation as needed:

- **README.md**: Update for new features or changes
- **INSTALLATION.md**: Update installation instructions
- **Code Comments**: Add inline documentation
- **API Documentation**: Update API endpoints

## 🐛 Bug Reports

When reporting bugs, please include:

1. **Environment Information**
   - OS and version
   - PHP version
   - Laravel version
   - Database type and version
   - Browser (if frontend issue)

2. **Steps to Reproduce**
   - Clear, numbered steps
   - Expected vs actual behavior
   - Screenshots or videos if helpful

3. **Error Messages**
   - Full error messages
   - Stack traces
   - Log files (remove sensitive data)

## ✨ Feature Requests

For feature requests, please:

1. **Check existing issues** first
2. **Describe the feature** clearly
3. **Explain the use case** and benefits
4. **Consider implementation** complexity
5. **Provide examples** if possible

## 🏷️ Release Process

Releases are managed by the maintainers:

1. **Version bumping** follows semantic versioning
2. **Changelog** is updated with all changes
3. **Documentation** is updated for new features
4. **Migration guide** provided for breaking changes

## 📞 Getting Help

- **GitHub Issues**: For bugs and feature requests
- **Discussions**: For questions and general discussion
- **Email**: support@codebundles.com
- **Documentation**: [INSTALLATION.md](INSTALLATION.md)

## 📄 Code of Conduct

Please read and follow our [Code of Conduct](CODE_OF_CONDUCT.md). We are committed to providing a welcoming and inclusive environment for all contributors.

## 🙏 Recognition

Contributors will be recognized in:
- **README.md** contributors section
- **Release notes** for significant contributions
- **GitHub contributors** page

Thank you for contributing to OSR Digital! 🎉
