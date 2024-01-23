// Auto-generated do not edit

/* eslint-disable import/no-extraneous-dependencies */
/* eslint-disable no-undef */
import React from 'react';
import renderer from 'react-test-renderer';
import app from '../app';

describe('app test', () => {
  it('app should match snapshot', () => {
    const component = renderer.create(<app />);
    const tree = component.toJSON();
    expect(tree).toMatchSnapshot();
  });
});
