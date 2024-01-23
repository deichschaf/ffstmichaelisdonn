import React from 'react';
import { PageHeadlineProps } from '../../../props/props';
import PageTitle from '../PageTitle';
import H1 from '../Typography/H1';

const PageHeadline: React.FC<React.PropsWithChildren<PageHeadlineProps>> = (
  props: PageHeadlineProps,
): JSX.Element => (
  <>
    <PageTitle pageTitle={props.label} />
    <H1 label={props.label} />
  </>
);

export default PageHeadline;
