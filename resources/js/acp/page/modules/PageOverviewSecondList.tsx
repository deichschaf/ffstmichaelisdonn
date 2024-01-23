import React from 'react';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { PageOverviewSecondListProps } from '../../../props/props';
import PageOverviewSecond from './PageOverviewSecond';

const PageOverviewSecondList: React.FC<React.PropsWithChildren<PageOverviewSecondListProps>> = (
  props: PageOverviewSecondListProps,
): JSX.Element => (
  <ErrorBoundary>
    {props.upages.map((item, idx) => (
      <PageOverviewSecond
        key={idx}
        page={item.page}
        upages={item.upage}
        deletepath={props.deletepath}
        editpath={props.editpath}
        editheadlinepath={props.editheadlinepath}
        pagecontenttypes={props.pagecontenttypes}
      />
    ))}
  </ErrorBoundary>
);
export default PageOverviewSecondList;
