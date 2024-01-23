import React from 'react';
import { composeStories } from '@storybook/testing-react';
import { render } from '@testing-library/react';
import * as BlackdayMessageStories from './index.stories';

const { Primary } = composeStories(BlackdayMessageStories);

describe('Atoms - Blackday Message', () => {
  it('renders correctly', () => {
    render(<Primary />);
  });
});
