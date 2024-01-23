module.exports = {
  collectCoverageFrom: [
    '**/(src|pages|components|utils|typings)/**',
    '!**/(src|pages|components|utils|typings)/**/(*.(json|d.ts|scss|css|snap|svg|png|stories.tsx|data.tsx|data.ts)|index.ts)',
  ],
  coverageReporters: ['json', 'cobertura'],
};
