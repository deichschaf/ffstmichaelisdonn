import React from 'react';
import { composeStories } from '@storybook/testing-react';
import { render } from '@testing-library/react';
import * as BreadcrumbStories from './index.stories';

const { Primary } = composeStories(BreadcrumbStories);

describe('Atoms - Breadcrumb', () => {
  it('renders correctly', () => {
    render(<Primary />);
  });
});
