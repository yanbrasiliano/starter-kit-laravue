import { defineConfig } from 'changelogen'

export default defineConfig({
  types: {
    feat: { title: '🚀 Features', semver: 'minor' },
    fix: { title: '🐛 Bug Fixes', semver: 'patch' },
    perf: { title: '⚡ Performance', semver: 'patch' },
    refactor: { title: '♻️  Refactors', semver: 'patch' },
    docs: { title: '📚 Documentation', semver: 'patch' },
    style: { title: '💅 Styles', semver: 'patch' },
    test: { title: '✅ Tests', semver: 'patch' },
    build: { title: '📦 Build', semver: 'patch' },
    ci: { title: '🤖 CI/CD', semver: 'patch' },
    chore: { title: '🏡 Chore', semver: 'patch' },
    revert: { title: '⏪ Reverts', semver: 'patch' },
    security: { title: '🔒 Security', semver: 'patch' }
  },

  repo: {
    provider: 'github',
    repo: 'your-username/your-repo',
    // domain: 'github.com', // optional for GitHub Enterprise
    // token: process.env.GITHUB_TOKEN // for private repos
  },

  output: 'CHANGELOG.md',
  
  excludeAuthors: [
    'dependabot[bot]',
    'renovate[bot]'
  ],

  // Change title based on your project
  name: 'StarterKit',
  
  // Custom scopes for your Laravel project
  scopes: {
    api: 'API',
    auth: 'Authentication',
    ui: 'User Interface',
    db: 'Database',
    tests: 'Testing',
    docker: 'Docker',
    deps: 'Dependencies'
  },

  from: '2.0.0', // Start from latest tag
  to: 'HEAD',
  
  // Changelog sections order
  sections: [
    '🚀 Features',
    '🐛 Bug Fixes',
    '⚡ Performance',
    '♻️  Refactors',
    '📚 Documentation',
    '💅 Styles',
    '✅ Tests',
    '📦 Build',
    '🤖 CI/CD',
    '🔒 Security',
    '🏡 Chore',
    '⏪ Reverts'
  ]
})