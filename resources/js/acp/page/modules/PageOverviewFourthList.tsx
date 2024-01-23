import React from 'react';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { PageOverviewFourthListProps } from '../../../props/props';
import PageOverviewFourth from './PageOverviewFourth';

const PageOverviewFourthList: React.FC<React.PropsWithChildren<PageOverviewFourthListProps>> = (
  props: PageOverviewFourthListProps,
): JSX.Element => (
  <ErrorBoundary>
    {props.upages.map((item, idx) => (
      <PageOverviewFourth
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
export default PageOverviewFourthList;
